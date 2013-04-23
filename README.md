silverstripe-i18nenum
=====================

Translatable Enum fieldtype

## Maintainer Contact

Elvinas Liutkevičius

<elvinas (at) unisolutions (dot) eu>

## Requirements

SilverStripe 3

## Documentation

Simply install the module using the standard method.

Now you can create datafield with translatable enum Field:

	class MyDataObject extends DataObject {
		public static $db = array(
			'DbField' => "i18nEnum('default, other', 'default')",
		);
	}

To get translated Enum value in GridField, you need to return the value in this way:

	class MyDataObject extends DataObject {
		...
		public function DbField() {
			return i18nEnum::getTranslatedValue($this->className, __FUNCTION__, $this->{__FUNCTION__});
		}
	}

By default translation namespace will be your DataObject class name and the entity will be constructed like this: "db_{DbField}_{enum value}".
So your translation file should look like this:

	lang:
	  MyDataObject:
	    db_DbField_default: 'Default'
	    db_DbField_other: 'Other'

## Known issues

*  GridField filtering in GridFieldFilterHeader won't work as expected - it still constructs the search filter using enum values only.