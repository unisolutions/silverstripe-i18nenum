<?php
/**
 * Class i18nEnum represents an enumeration of a set of strings in current language.
 *
 * See {@link DropdownField} for a {@link FormField} to select enum values.
 *
 * @package framework
 * @subpackage model
 * @author Elvinas Liutkevičius <elvinas@unisolutions.eu>
 * @license BSD http://silverstripe.org/BSD-license
 */

class i18nEnum extends Enum {

	/**
	 *  used form i18n namespace, we'll set it to the table name
	 */
	private $DbObjectName = 'Enum';

	/**
	 *  set i18n namespace to the table name
	 */
	public function setValue($value, $record = null) {
		parent::setValue($value, $record);
		if (is_array($record)) {
			$record = (object) $record;
		}
		if ($record && !empty($record->ClassName)) {
			$this->DbObjectName = $record->ClassName;
		}
	}

	/**
	 *  return translated (if it is set) value
	 */
	public function enumValues($hasEmpty = false) {
		$translated_options = array();

		$options = $hasEmpty ? array_merge(array('' => ''), $this->enum) : $this->enum;
		if (!empty($options)) {
			foreach ($options as $value) {
				$translated_options[$value] = self::getTranslatedValue($this->DbObjectName, $this->getName(), $value);
			}
		}

		return $translated_options;
	}

	/**
	 *  returns translated enum value
	 *  This static method can be used in your data object to get translated value in {@link GridField}
	 *
	 * Example:
	 * <code php>
	 * class YourDataObject extends DataObject {
	 *    public function EnumField() {
	 *     return i18nEnum::getTranslatedValue($this->className, __FUNCTION__, $this->{__FUNCTION__});
	 *    }
	 * }
	 * </code>
	 *
	 */
	public static function getTranslatedValue($namespace, $name, $value) {
		return _t($namespace.'.db_'.$name.'_'.$value, $value);
	}

}
