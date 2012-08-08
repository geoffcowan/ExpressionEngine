<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2012, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */

// --------------------------------------------------------------------

/**
 * ExpressionEngine Rich Text Fieldtype Class
 *
 * @package		ExpressionEngine
 * @subpackage	Fieldtypes
 * @category	Fieldtypes
 * @author		EllisLab Dev Team
 * @link		http://expressionengine.com
 */
class Rte_ft extends EE_Fieldtype {

	var $info = array(
		'name'		=> 'Textarea (Rich Text)',
		'version'	=> '1.0'
	);
	
	var $has_array_data = FALSE;
	
	function __construct()
	{
		parent::__construct();
		
		$this->EE->load->library('rte_lib');
	}

	// --------------------------------------------------------------------

	function validate($data)
	{
		if ($this->settings['field_required'] === 'y' && $this->EE->rte_lib->is_empty($data))
		{
			return lang('required');
		}
		
		return TRUE;
	}

	// --------------------------------------------------------------------

	function display_field($data)
	{
		return $this->EE->rte_lib->display_field($data, $this->field_name, $this->settings);
	}

	// --------------------------------------------------------------------

	function save($data)
	{
		return $this->EE->rte_lib->save_field($data);
	}

	// --------------------------------------------------------------------

	function replace_tag($data, $params = '', $tagdata = '')
	{
		return $data;
	}
	
	// --------------------------------------------------------------------
	
	function display_settings($data)
	{
		$prefix = 'rte';

		// Text direction
		$this->text_direction_row($data, $prefix);

		// Textarea rows
		$field_rows	= ($data['field_ta_rows'] == '') ? 10 : $data['field_ta_rows'];

		$this->EE->table->add_row(
			lang('textarea_rows', $prefix.'_ta_rows'),
			form_input(array(
				'id'	=> $prefix.'_ta_rows',
				'name'	=> $prefix.'_ta_rows',
				'size'	=> 4,
				'value'	=> $field_rows
				)
			)
		);
	}
	
	// --------------------------------------------------------------------

	function save_settings($data)
	{		
		$data['field_type'] = 'rte';
		$data['field_show_fmt'] = 'n';
		$data['field_ta_rows'] = $this->EE->input->post('rte_ta_rows');

		return $data;
	}	
}

// END Rte_ft class

/* End of file ft.rte.php */
/* Location: ./system/expressionengine/modules/ft.rte.php */