<?php
namespace Bromo\Transaction\Helpers;

class ShippingAddressUtil {

    /**
     * Get only the subdistrict part
     */
    public static function getLocationId ( $address_snapshot ) {
      // Location ID format: 20033442655475248
      // 200 33 442 6554 75248
      // COUNTRY PROVINCE CITY DISTRICT SUBDISTRICT

      $location_id = $address_snapshot['location_id'];
      return intval(substr($location_id, 12));
  }

  /**
   * Get a full address detail
   */
  public static function getAddressDetails ( $address_snapshot ) {
      $address_line = $address_snapshot['address_line'];
      $building_name = $address_snapshot['building_name'];
      $postal_code = $address_snapshot['postal_code'];
      $province = $address_snapshot['province'];
      $city = $address_snapshot['city'];
      $district = $address_snapshot['district'];
      $subdistrict = $address_snapshot['subdistrict'];

      return "$building_name $address_line, $subdistrict $district, $city, $province $postal_code";
  }

}