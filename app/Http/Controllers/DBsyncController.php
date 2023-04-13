<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use DB;

class DBsyncController extends Controller
{

    public $error = null;
    private $config_remote;
    private $remote_connection;
    private $allConstraints = [];
    private $allPrimaryKeys = [];
    private $missing = [];
    private $existing = [];
    private $generalIndexes = [];


    public function __construct($remote_connection_config = null)
    {
        try{
            if(!$remote_connection_config) {
                $this->config_remote = config('database.connections.remote') ?? [];
            }
            \Config::set("database.connections.{$this->config_remote['CON_NAME']}", [
                'driver'    => 'mysql',
                'host'      => $this->config_remote['DB_HOST'],
                'port'      => $this->config_remote['DB_PORT'],
                'database'  => $this->config_remote['DB_DATABASE'],
                'username'  => $this->config_remote['DB_USERNAME'],
                'password'  => $this->config_remote['DB_PASSWORD'],
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
             ]);
            $this->remote_connection = \DB::connection($this->config_remote['CON_NAME']);
            $this->remote_connection ->getPdo();
        } catch( Exception $error ){
            Log::error($error);
            $this->setError($error->getMessage());
        }
    }

    public function setError($errorText){
        $this->error = $errorText;
    }

    private function getLocalTables() {
         $tablesData = DB::select("SHOW TABLES");
         $tableNames= array();

         foreach($tablesData as $i => $tableName) {
            foreach(get_object_vars($tableName) as $ii => $val){
                $tableNames[] = $val;
            }
         }

         return $tableNames;
    }

    private function getExistingAndMissingTables($tableNames) {
         $existing = array();
         $missing = array();
         //Loop through each and store which table exists and which not [in External DB]
         foreach($tableNames as $tableName) {
            $count = $this->remote_connection->select("SHOW TABLES FROM `".$this->config_remote['DB_DATABASE']."` LIKE '{$tableName}';");
            if($count) {
                $existing[] = $tableName;
            } else {
                $missing[] = $tableName;
            }
         }

         $this->existing = $existing;
         $this->missing = $missing;
    }

    private function loopThroughMissing() {
         shuffle($this->missing);
         foreach($this->missing as $table) {

            //Save Keys
            $constraints = DB::select("SELECT *
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_NAME LIKE '{$table}'
            AND TABLE_SCHEMA = '" . config('database.connections.mysql.database') . "'
            AND REFERENCED_TABLE_NAME IS NOT NULL;");
            foreach($constraints as $constraint) {
                $this->allConstraints[] = $constraint;
            }

            $primaries = DB::select("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");
            foreach($primaries as $primary){
                $this->allPrimaryKeys[] = $primary;
            }


            $generalIndexes = DB::select("SHOW INDEX FROM {$table}");
            foreach($generalIndexes as $index){
              if($this->endswith($index->Key_name, "_index")) {
                $this->generalIndexes[] = $index;
              }
            }

            $copyTableName = $table . "_copy";
            DB::select("CREATE TABLE IF NOT EXISTS " .$copyTableName . "  SELECT * FROM {$table} WHERE 1=0");
            $key = "Create Table";
            $showCreate = DB::select("SHOW CREATE TABLE {$copyTableName}")[0]->{$key};
            $showCreate = str_replace($copyTableName,$table,$showCreate);

            //Delete Clone
            DB::select("DROP TABLE {$copyTableName}");

            $this->remote_connection->select($showCreate);
            echo "Created non existing table {$table}\n";
         }
    }

    private function endsWith($haystack, $needle) {
      return substr_compare($haystack, $needle, -strlen($needle)) === 0;
   }

    private function loopThroughExisting() {
           //Loop through    existing
         shuffle($this->existing);
         foreach($this->existing as $table) {

            //Save Keys
            $constraints = DB::select("SELECT *
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_NAME LIKE '{$table}'
            AND TABLE_SCHEMA = '" .config('database.connections.mysql.database')."'
            AND REFERENCED_TABLE_NAME IS NOT NULL;");

            foreach($constraints as $constraint) {
                $this->allConstraints[] = $constraint;
            }

            $primaries = DB::select("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");
            foreach($primaries as $primary){
                $this->allPrimaryKeys[] = $primary;
            }

            $generalIndexes = DB::select("SHOW INDEX FROM {$table}");
            foreach($generalIndexes as $index){
              if($this->endswith($index->Key_name, "_index")) {
                $this->generalIndexes[] = $index;
              }
            }

            $fieldsArray = DB::select("Show columns from {$table}");
            $fields = [];
            foreach($fieldsArray as $fieldObject){
                $fields[] = $fieldObject->Field;
            }

            foreach($fields as $fieldName) {
                //Check if field exists on remote database
                if(!count($this->remote_connection->select("SHOW COLUMNS FROM ${table} LIKE '{$fieldName}';"))) {
                    $columnInfo = DB::select("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".config('database.connections.mysql.databasee')."' AND TABLE_NAME = '{$table}' AND COLUMN_NAME = '{$fieldName}'");

                    $columnType = $columnInfo[0]->COLUMN_TYPE;
                    $columnNullable = $columnInfo[0]->IS_NULLABLE;
                    $statement = "ALTER TABLE {$table} ADD column {$fieldName} {$columnType}";
                    if($columnNullable == true){
                        $statement .= " NULL DEFAULT NULL";
                    }
                    echo "Column {$fieldName} was not existed so it was created on table {$table}. \n";
                    $statement .= ";";
                    $this->remote_connection->select("SET sql_mode = '';");
                    $this->remote_connection->select($statement);

                } else {
                    $columnInfo = DB::select("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".config('database.connections.mysql.database')."' AND TABLE_NAME = '{$table}' AND COLUMN_NAME = '{$fieldName}'");

                    $columnType = $columnInfo[0]->COLUMN_TYPE;
                    $columnNullable = $columnInfo[0]->IS_NULLABLE;
                    $statement = "ALTER TABLE {$table} MODIFY column `{$fieldName}` {$columnType}";
                    if($columnNullable == true){
                        $statement .= " NULL DEFAULT NULL";
                    }
                    echo "Column {$fieldName} ($columnType) was existed and was updated on table {$table}. \n";
                    $statement .= ";";
                    $this->remote_connection->select("SET sql_mode = '';");
                    $this->remote_connection->select($statement);
                }
            }


        }
    }

    private function deleteForeignKeys() {
        $foreignsArray = $this->remote_connection->select("SELECT concat('alter table `',table_schema,'`.`',table_name,'` DROP FOREIGN KEY ',constraint_name,';') as stm
        FROM information_schema.table_constraints
        WHERE constraint_type='FOREIGN KEY'
        AND table_schema='" . $this->config_remote['DB_DATABASE'] . "';");
        $deleteForeignStatements = [];
        foreach($foreignsArray as $obj){
            $deleteForeignStatements[] = $obj->stm;
        }

        foreach($deleteForeignStatements as $statement){
            $this->remote_connection->select($statement);
        }
    }

    private function addPrimaryAndForeigns() {

         foreach($this->allPrimaryKeys as $primaryObject) {
            $hasPrimaryCommand = "SHOW INDEXES FROM {$primaryObject->Table} WHERE Key_name = 'PRIMARY'";
            if(! count($this->remote_connection->select($hasPrimaryCommand))) {
                $primaryCommand = "alter table {$primaryObject->Table} add primary key ({$primaryObject->Column_name})";
                $this->remote_connection->select($primaryCommand);
            }
         }

         foreach($this->allConstraints as $constraintObject) {

              $foreignCommand = "ALTER TABLE " . $constraintObject->TABLE_NAME . " ADD CONSTRAINT " . $constraintObject->CONSTRAINT_NAME . " FOREIGN KEY (". $constraintObject->COLUMN_NAME . ") REFERENCES ".  $constraintObject->REFERENCED_TABLE_NAME . "(". $constraintObject->REFERENCED_COLUMN_NAME . ")";
              $this->remote_connection->select($foreignCommand);
         }
    }

    private function addGeneralIndexes() {
      foreach($this->generalIndexes as $generalObject) {
              $existing = $this->remote_connection->select("SHOW KEYS FROM  {$generalObject->Table} WHERE Key_name='{$generalObject->Key_name}'");
              if(!count($existing)){

                  $foreignCommand = "CREATE INDEX {$generalObject->Key_name} ON {$generalObject->Table} ({$generalObject->Column_name})";
                  $this->remote_connection->select($foreignCommand);
              }
         }
    }

    public function handle(){

        try{

         //Get all tables, find missing tables and existing tables
         $tableNames = $this->getLocalTables();
         $existingAndMissing = $this->getExistingAndMissingTables($tableNames);

         //Loop through missing tables & create them with the correct structures
         $this->loopThroughMissing();

         //Loop through existing tables & check for added/changed columns
         $this->loopThroughExisting();


         //Delete all foreign keys on remote databas (to avoid problems)
         $this->deleteForeignKeys();

         //Add new primary &  foreign keys
         $this->addPrimaryAndForeigns();

         $this->addGeneralIndexes();

         echo('Synchronization finished successfully.');

        } catch( Exception $error ){
            Log::error($error);
            $this->setError($error->getMessage());
        }
    }


}
