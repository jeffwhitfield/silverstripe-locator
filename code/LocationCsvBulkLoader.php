<?php
class LocationCsvBulkLoader extends CsvBulkLoader {
  public $columnMap = array(
    'Name' => 'Title',
    'Store' => 'Store',
    'Address' => 'Address',
    'Address2' => 'Address2',
    'City' => 'Suburb',
    'State' => 'State',
    'Zip' => 'Postcode',
    'Category' => 'Category.Name',
    'Website' => 'Website',
    'Email' => 'EmailAddress',
    'Phone' => 'Phone',
    'Collections' => 'Collections',
    'Featured' => 'Featured',
  );

  public $duplicateChecks = array(
    'Address' => 'Address',
    'Website' => 'Website'
  );

  public $relationCallbacks = array(
      'Category.Name' => array(
      'relationname' => 'Category',
      'callback' => 'getCatByName'
    )
  );

  public static function getCatByName(&$obj, $val, $record) {
    $val = Convert::raw2sql($val);
    return LocationCategory::get()->filter('Name', $val)->First();
  }
}
