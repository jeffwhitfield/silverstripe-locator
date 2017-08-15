<?php
class Location extends DataObject implements PermissionProvider{

	static $db = array(
		'Title' => 'Varchar(255)',
		'Store' => 'Varchar(255)',
		'Featured' => 'Boolean',
		'Website' => 'Varchar(255)',
		'Phone' => 'Varchar(40)',
		'EmailAddress' => 'Varchar(255)',
		'Collections' => 'Text',
		'ShowInLocator' => 'Boolean',
	);

	static $has_one = array(
		'Category' => 'LocationCategory',
		'Locator' => 'Locator'
	);

	static $casting = array(
		'distance' => 'Int'
	);

	static $default_sort = 'Title';

	static $defaults = array(
		'ShowInLocator' => true
	);

	public static $singular_name = "Location";
	public static $plural_name = "Locations";

	// api access via Restful Server module
	static $api_access = true;

  // search fields for Model Admin
  private static $searchable_fields = array(
    'Title' => 'Title',
    'Store' => 'Store #',
    'Address' => 'Address',
    'Address2' => 'Address 2',
    'Suburb' => 'Suburb',
    'State' => 'State',
    'Postcode' => 'Postcode',
    'Country' => 'Country',
    'Category.ID' => 'Category',
    'ShowInLocator' => 'Show in Locator',
    'Featured' => 'Featured',
    'Website' => 'Website',
    'Phone' => 'Phone',
    'EmailAddress' => 'Email'
  );

	// columns for grid field
	static $summary_fields = array(
		'Title' => 'Title',
		'Store' => 'Store',
		'Address' => 'Address',
		'Address2' => 'Address 2',
		'Suburb' => 'Suburb',
		'State' => 'State',
		'Postcode' => 'Postcode',
		'Country' => 'Country',
		'Category.Name' => 'Category',
		'ShowInLocator.NiceAsBoolean' => 'Show in Locator',
		'Featured.NiceAsBoolean' => 'Featured',
		'Coords' => 'Coordinates'
	);

	// Coords status for $summary_fields
	public function getCoords() {
		return ($this->Lat != 0 && $this->Lng != 0) ? 'true' : 'false';
	}

    // custom labels for fields
	function fieldLabels($includerelations = true) {
		$labels = parent::fieldLabels();

		$labels['Title'] = 'Name';
		$labels['Store'] = 'Store #';
		$labels['Suburb'] = "City";
		$labels['Postcode'] = 'Postal Code';
		$labels['ShowInLocator'] = 'Show';
		$labels['ShowInLocator.NiceAsBoolean'] = 'Show';
		$labels['Category.Name'] = 'Category';
		$labels['EmailAddress'] = 'Email';
		$labels['Collections'] = 'Collections';
		$labels['Featured.NiceAsBoolean'] = 'Featured';
		$labels['Coords'] = 'Coords';

		return $labels;
 	}

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		// remove Main tab
		$fields->removeByName('Main');

		// If collections are available, show collections checkbox set
		if (CollectionPage::get()->Count() > 0) {
			$fields->addFieldToTab('Root.Main', CheckboxSetField::create('Collections', 'Collections', CollectionPage::get()->sort('Title')->map('Title', 'Title'))->setEmptyString('-- select --'));
		} else {
			$fields->addFieldToTab('Root.Main', TextField::create('Collections', 'Collections'));
		}

		// create and populate Info tab
		$fields->addFieldsToTab('Root.Info', array(
			HeaderField::create('InfoHeader', 'Contact Information'),
			TextField::create('Store'),
			TextField::create('Website'),
			TextField::create('EmailAddress'),
			TextField::create('Phone')
		));

		// If categories have been created, show category drop down
		if (LocationCategory::get()->Count() > 0) {
			$fields->insertAfter(DropDownField::create('CategoryID', 'Category', LocationCategory::get()->map('ID', 'Title'))->setEmptyString('-- select --'), 'Phone');
		}

		// move Title and ShowInLocator fields to Address tab from Addressable
		$fields->insertAfter(TextField::create('Title'), 'AddressHeader');
		$fields->insertAfter(CheckboxField::create('Featured', 'Featured'), 'Title');
		$fields->insertAfter(CheckboxField::create('ShowInLocator', 'Show on Map'), 'Country');

		// allow to be extended via DataExtension
		$this->extend('updateCMSFields', $fields);

		return $fields;
	}

  public function validate() {
    $result = parent::validate();
    if(Locator::getMultipleLocators() && $this->LocatorID == 0) {
      $result->error('You must associate this location with a locator page. Add the location from the desired locator page.');
    }
    return $result;
  }

	/**
	 * @param Member $member
	 * @return boolean
	 */
	public function canView($member = false) {
		//return Permission::check('Location_VIEW');
		return true;
	}

	public function canEdit($member = false) {
		return Permission::check('Location_EDIT');
	}

	public function canDelete($member = false) {
		return Permission::check('Location_DELETE');
	}

	public function canCreate($member = false) {
		return Permission::check('Location_CREATE');
	}

	public function providePermissions() {
		return array(
			//'Location_VIEW' => 'Read a Location',
			'Location_EDIT' => 'Edit a Location',
			'Location_DELETE' => 'Delete a Location',
			'Location_CREATE' => 'Create a Location'
		);
	}

	public function onBeforeWrite(){

		if(Locator::get()->count() == 1){
			$this->LocatorID = Locator::get()->first()->ID;
		}

		parent::onBeforeWrite();
	}

}
