<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Default route
	 * -------------------------------------------------------------------------
	 *
	 */

	'_root_' => 'site/home/index',

	/**
	 * -------------------------------------------------------------------------
	 *  Page not found
	 * -------------------------------------------------------------------------
	 *
	 */

	'_404_' => 'welcome/404',

    /**
     * -------------------------------------------------------------------------
     *  Site routes
     * -------------------------------------------------------------------------
     */
    // About
    'about-us' => 'site/about/index',
    // Contact
    'contact' => 'site/contact/index',
    // New
    'new' => 'site/new/index',
    'new/(:num)' => 'site/new/detail/$1',
    // Room
    'room' => 'site/room/index',
    // Social auth
    'auth/google' => 'admin/auth/google',
    'auth/google/callback' => 'admin/auth/google_callback',
    'auth/facebook' => 'admin/auth/facebook',
    'auth/facebook/callback' => 'admin/auth/facebook_callback',
    // Room Detail
    'room/(:num)' => 'site/room/detail/$1',


	/**
	 * -------------------------------------------------------------------------
	 *  Admin routes
	 * -------------------------------------------------------------------------
	 */
    // Dashboard
    'admin' => 'admin/dashboard/index',

	// Auth
	'admin/login' => 'admin/auth/login',
	'admin/register' => 'admin/auth/register',
	'admin/forgot' => 'admin/auth/forgot',
    'admin/verify' => 'admin/auth/verify',
	'admin/logout' => 'admin/auth/logout',

	// Admin management
	'admin/admins' => 'admin/admins/index',
	'admin/admins/index' => 'admin/admins/index',
	'admin/admins/create' => 'admin/admins/create',
	'admin/admins/edit/(:num)' => 'admin/admins/edit/$1',
	'admin/admins/toggle/(:num)' => 'admin/admins/toggle/$1',
	'admin/admins/reset_password/(:num)' => 'admin/admins/reset_password/$1',

	// Hotel management
	'admin/hotels' => 'admin/hotels/index',
	'admin/hotels/index' => 'admin/hotels/index',
	'admin/hotels/create' => 'admin/hotels/create',
	'admin/hotels/edit/(:num)' => 'admin/hotels/edit/$1',
	'admin/hotels/toggle/(:num)' => 'admin/hotels/toggle/$1',
	'admin/hotels/delete/(:num)' => 'admin/hotels/delete/$1',
	'admin/hotels/delete-image/(:num)' => 'admin/hotels/delete_image/$1',

    // Room management
    'admin/rooms' => 'admin/rooms/index',
    'admin/rooms/index' => 'admin/rooms/index',
    'admin/rooms/create' => 'admin/rooms/create',
    'admin/rooms/edit/(:num)' => 'admin/rooms/edit/$1',
    'admin/rooms/toggle/(:num)' => 'admin/rooms/toggle/$1',
    'admin/rooms/delete/(:num)' => 'admin/rooms/delete/$1',
    'admin/rooms/delete-image/(:num)' => 'admin/rooms/delete_image/$1',

    // Location helpers
    'admin/wards/by-province/(:num)' => 'admin/hotels/wards/$1',

    // Contact management
    'admin/contacts' => 'admin/contacts/index',
    'admin/contacts/index' => 'admin/contacts/index',
    'admin/contacts/view/(:num)' => 'admin/contacts/view/$1',
    'admin/contacts/update_status/(:num)' => 'admin/contacts/update_status/$1',
    'admin/contacts/delete/(:num)' => 'admin/contacts/delete/$1',

    // Blog management
    'admin/blogs' => 'admin/blogs/index',
    'admin/blogs/index' => 'admin/blogs/index',
    'admin/blogs/create' => 'admin/blogs/create',
    'admin/blogs/edit/(:num)' => 'admin/blogs/edit/$1',
    'admin/blogs/toggle/(:num)' => 'admin/blogs/toggle/$1',
    'admin/blogs/delete/(:num)' => 'admin/blogs/delete/$1',
    'admin/blogs/delete-image/(:num)' => 'admin/blogs/delete_image/$1',

    // Room Availability management
    'admin/room-availability' => 'admin/availability/index',
    'admin/room-availability/index' => 'admin/availability/index',
    'admin/room-availability/create' => 'admin/availability/create',
    'admin/room-availability/update/(:num)' => 'admin/availability/update/$1',
    'admin/room-availability/get/(:num)' => 'admin/availability/get/$1',
    'admin/room-availability/delete/(:num)' => 'admin/availability/delete/$1',

    // Hotel Policies management
    'admin/hotel-policies' => 'admin/policies/index',
    'admin/hotel-policies/index' => 'admin/policies/index',
    'admin/hotel-policies/create' => 'admin/policies/create',
    'admin/hotel-policies/update/(:num)' => 'admin/policies/update/$1',
    'admin/hotel-policies/get/(:num)' => 'admin/policies/get/$1',
    'admin/hotel-policies/delete/(:num)' => 'admin/policies/delete/$1',

    // Booking management
    'admin/bookings' => 'admin/bookings/index',
    'admin/bookings/index' => 'admin/bookings/index',
    'admin/bookings/view/(:num)' => 'admin/bookings/view/$1',
    'admin/bookings/update_status/(:num)' => 'admin/bookings/update_status/$1',
    'admin/bookings/cancel/(:num)' => 'admin/bookings/cancel/$1',
    'admin/bookings/delete/(:num)' => 'admin/bookings/delete/$1',

	// Category management
	'admin/categories' => 'admin/categories/index',
	'admin/categories/index' => 'admin/categories/index',
	'admin/categories/create' => 'admin/categories/create',
	'admin/categories/edit/(:num)' => 'admin/categories/edit/$1',
	'admin/categories/toggle/(:num)' => 'admin/categories/toggle/$1',
	'admin/categories/delete/(:num)' => 'admin/categories/delete/$1',

    // Amenity management
    'admin/amenities' => 'admin/amenities/index',
    'admin/amenities/index' => 'admin/amenities/index',
    'admin/amenities/create' => 'admin/amenities/create',
    'admin/amenities/edit/(:num)' => 'admin/amenities/edit/$1',
    'admin/amenities/toggle/(:num)' => 'admin/amenities/toggle/$1',
    'admin/amenities/delete/(:num)' => 'admin/amenities/delete/$1',
);
