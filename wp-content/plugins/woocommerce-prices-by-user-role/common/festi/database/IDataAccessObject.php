<?php
interface IDataAccessObject
{
	public function getRow($sql);
    public function getAll($sql);
    public function getOne($sql);
    public function getAssoc($sql);
    public function getCol($sql);
	
	public function query($sql);
    public function insert($table, $values, $isUpdateDublicate = false);
    public function update($table, $values, $condition);
    public function delete($table, $condition);
	public function massInsert($table, $values);
	public function getInsertID();

    public function begin($isolationLevel = false);
    public function commit();
    public function rollback();
	
	public function quote($obj, $type);
	public function quoteTableName($name);
	public function quoteColumnName($name);
	
	/**
	 * Returns type of databases mysql, mssql etc.
	 * @retrun string
	 */
	public function getDatabaseType();

    /**
     * Returns tables list.
     *
     * @return mixed
     */
	public function getTables();

    /**
     * Enable or disable foreign key checks.
     *
     * @param $isEnable = true
     * @return boolean
     */
    public function setForeignKeyChecks($isEnable = true);

    /**
     * Remove a table.
     * @param $table
     * @return mixed
     */
    public function deleteTable($table);
}