<?php

class HCBRWPB_Utils{

	static function user_has_role( $user_id, $role ) {

		$user = get_userdata( $user_id );

		if ( ! $user ) {
			return false;
		}

		return in_array( $role, $user->roles, true );
	}

	/**
	 * return labels and keys of roles
	 *
	 * @return array
	 */
	static function get_roles(){

		$roles = get_editable_roles();

		$values = array();
		// Logged out users
		$values[__( "Logged-out users", 'hide-content-by-role-for-wpbakery' )] = 'logged_out';
		foreach ( $roles as $role_key => $role_value ) {
			$values[ $role_value['name'] ] = $role_key;
		}
		return $values;
	}

}
