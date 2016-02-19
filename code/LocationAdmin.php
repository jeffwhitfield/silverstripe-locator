<?php
class LocationAdmin extends ModelAdmin {

  static $managed_models = array(
    'Location',
    'LocationCategory'
  );

  static $model_importers = array(
    'Location' => 'LocationCsvBulkLoader',
    'LocationCategory' => 'CsvBulkLoader'
  );

	static $menu_title = 'Locator';
  static $url_segment = 'locator';

  public function getExportFields() {
    return array(
      'Title' => 'Name',
      'Address' => 'Address',
      'Address2' => 'Address2',
      'Suburb' => 'City',
      'State' => 'State',
      'Postcode' => 'Postcode',
      'Country' => 'Country',
      'Lat' => 'Lat',
      'Lng' => 'Lng',
      'Store' => 'Store',
      'Website' => 'Website',
      'EmailAddress' => 'EmailAddress',
      'Phone' => 'Phone',
      'Collections' => 'Collections',
      'Featured' => 'Featured',
      'SubsiteID' => 'SubsiteID',
    );
  }
}
