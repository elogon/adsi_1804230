<?php

require_once 'wonderplugin-carousel-functions.php';

class WonderPlugin_Carousel_Model {

	private $controller;

	function __construct($controller) {

		$this->controller = $controller;

		$this->multilingual = false;

		if ( get_option( 'wonderplugin_carousel_supportmultilingual', 1 ) == 1 )
		{
			$defaultlang = apply_filters( 'wpml_default_language', NULL);
			if ( !empty($defaultlang) )
			{
				$this->multilingual = true;
				$this->multilingualsys = "wpml";
				$this->defaultlang = $defaultlang;
				$this->currentlang = apply_filters('wpml_current_language', NULL );
			}
		}
	}

	function get_upload_path() {

		$uploads = wp_upload_dir();
		return $uploads['basedir'] . '/wonderplugin-carousel/';
	}

	function get_upload_url() {

		$uploads = wp_upload_dir();
		return $uploads['baseurl'] . '/wonderplugin-carousel/';
	}

	function get_socialmedia_color($item) {

		$socialbgcolor = array(
			'facebook' => '#3b5998',
			'dribbble'=> '#d94a8b',
			'dropbox'=> '#477ff2',
			'mail'=> '#4d83ff',
			'flickr'=> '#3c58e6',
			'git'=> '#4174ba',
			'gplus'=> '#e45104',
			'instagram'=> '#d400c8',
			'linkedin'=> '#458bb7',
			'pinterest'=> '#c92228',
			'reddit'=> '#ee5300',
			'skype'=> '#53adf5',
			'tumblr'=> '#415878',
			'twitter'=> '#03b3ee',
			'link'=> '#517dd9',
			'whatsapp'=> '#72be44',
			'youtube'=> '#c7221b'
		);

		if ( array_key_exists($item, $socialbgcolor))
			return $socialbgcolor[$item];
		else
			return '#333333';
	}

	function xml_cdata( $str ) {

		if ( ! seems_utf8( $str ) ) {
			$str = utf8_encode( $str );
		}

		$str = '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $str ) . ']]>';

		return $str;
	}

	function replace_data($replace_list, $data)
	{
		foreach($replace_list as $replace)
		{
			$data = str_replace($replace['search'], $replace['replace'], $data);
		}

		return $data;
	}

	function search_replace_items($post)
	{
		$allitems = sanitize_text_field($_POST['allitems']);
		$itemid = sanitize_text_field($_POST['itemid']);

		$replace_list = array();
		for ($i = 0; ; $i++)
		{
			if (empty($post['standalonesearch' . $i]) || empty($post['standalonereplace' . $i]))
				break;

			$replace_list[] = array(
					'search' => str_replace('/', '\\/', sanitize_text_field($post['standalonesearch' . $i])),
					'replace' => str_replace('/', '\\/', sanitize_text_field($post['standalonereplace' . $i]))
			);
		}

		global $wpdb;

		if (!$this->is_db_table_exists())
			$this->create_db_table();

		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$total = 0;

		foreach($replace_list as $replace)
		{
			$search = $replace['search'];
			$replace = $replace['replace'];

			if ($allitems)
			{
				$ret = $wpdb->query( $wpdb->prepare(
						"UPDATE $table_name SET data = REPLACE(data, %s, %s) WHERE INSTR(data, %s) > 0",
						$search,
						$replace,
						$search
				));
			}
			else
			{
				$ret = $wpdb->query( $wpdb->prepare(
						"UPDATE $table_name SET data = REPLACE(data, %s, %s) WHERE INSTR(data, %s) > 0 AND id = %d",
						$search,
						$replace,
						$search,
						$itemid
				));
			}

			if ($ret > $total)
				$total = $ret;
		}

		if (!$total)
		{
			return array(
					'success' => false,
					'message' => 'No carousel modified' .  (isset($wpdb->lasterror) ? $wpdb->lasterror : '')
			);
		}

		return array(
				'success' => true,
				'message' => sprintf( _n( '%s carousel', '%s carousels', $total), $total) . ' modified'
		);
	}

	function import_carousel($post, $files)
	{
		if (!isset($files['importxml']))
		{
			return array(
					'success' => false,
					'message' => 'No file or invalid file sent.'
			);
		}

		if (!empty($files['importxml']['error']))
		{
			$message = 'XML file error.';

			switch ($files['importxml']['error']) {
				case UPLOAD_ERR_NO_FILE:
					$message = 'No file sent.';
					break;
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$message = 'Exceeded filesize limit.';
					break;
			}

			return array(
					'success' => false,
					'message' => $message
			);
		}

		if ($files['importxml']['type'] != 'text/xml')
		{
			return array(
					'success' => false,
					'message' => 'Not an xml file'
			);
		}

		add_filter( 'wp_check_filetype_and_ext', 'wonderplugin_carousel_wp_check_filetype_and_ext', 10, 4);

		$xmlfile = wp_handle_upload($files['importxml'], array(
				'test_form' => false,
				'mimes' => array('xml' => 'text/xml')
		));

		remove_filter( 'wp_check_filetype_and_ext', 'wonderplugin_carousel_wp_check_filetype_and_ext');

		if ( empty($xmlfile) || !empty( $xmlfile['error'] ) ) {
			return array(
					'success' => false,
					'message' => (!empty($xmlfile) && !empty( $xmlfile['error'] )) ? $xmlfile['error']: 'Invalid xml file'
			);
		}

		$content = file_get_contents($xmlfile['file']);

		$xmlparser = xml_parser_create();
		xml_parse_into_struct($xmlparser, $content, $values, $index);
		xml_parser_free($xmlparser);

		if (empty($index) || empty($index['WONDERPLUGINCAROUSEL']) || empty($index['ID']))
		{
			return array(
					'success' => false,
					'message' => 'Not an exported xml file'
			);
		}

		$keepid = (!empty($post['keepid'])) ? true : false;
		$authorid = sanitize_text_field($post['authorid']);

		$replace_list = array();
		for ($i = 0; ; $i++)
		{
			if (empty($post['olddomain' . $i]) || empty($post['newdomain' . $i]))
				break;

			$replace_list[] = array(
					'search' => str_replace('/', '\\/', sanitize_text_field($post['olddomain' . $i])),
					'replace' => str_replace('/', '\\/', sanitize_text_field($post['newdomain' . $i]))
			);
		}

		$items = Array();
		foreach($index['ID'] as $key => $val)
		{
			$items[] = Array(
					'id' => ($keepid ? $values[$index['ID'][$key]]['value'] : 0),
					'name' => $values[$index['NAME'][$key]]['value'],
					'data' => $this->replace_data($replace_list, $values[$index['DATA'][$key]]['value']),
					'time' => $values[$index['TIME'][$key]]['value'],
					'authorid' => $authorid
			);
		}

		if (empty($items))
		{
			return array(
					'success' => false,
					'message' => 'No carousel found'
			);
		}

		global $wpdb;

		if (!$this->is_db_table_exists())
			$this->create_db_table();

		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$total = 0;
		foreach($items as $item)
		{
			$ret = $wpdb->query($wpdb->prepare(
					"
					INSERT INTO $table_name (id, name, data, time, authorid)
					VALUES (%d, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE
					name=%s, data=%s, time=%s, authorid=%s
					",
					$item['id'], $item['name'], $item['data'], $item['time'], $item['authorid'],
					$item['name'], $item['data'], $item['time'], $item['authorid']
			));

			if ($ret)
				$total++;
		}

		if (!$total)
		{
			return array(
					'success' => false,
					'message' => 'No carousel imported' .  (isset($wpdb->lasterror) ? $wpdb->lasterror : '')
			);
		}

		return array(
				'success' => true,
				'message' => sprintf( _n( '%s carousel', '%s carousels', $total), $total) . ' imported'
		);

	}

	function export_carousel()
	{
		if ( !check_admin_referer('wonderplugin-carousel', 'wonderplugin-carousel-export') || !isset($_POST['allcarousel']) || !isset($_POST['carouselid']) || !is_numeric($_POST['carouselid']) )
			exit;

		$allcarousel = sanitize_text_field($_POST['allcarousel']);
		$carouselid = sanitize_text_field($_POST['carouselid']);

		if ($allcarousel)
			$data = $this->get_list_data(true);
		else
			$data = array($this->get_list_item_data($carouselid));

		header('Content-Description: File Transfer');
		header("Content-Disposition: attachment; filename=wonderplugin_carousel_export.xml");
		header('Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true);
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: 0");
		$output = fopen("php://output", "w");

		echo '<?xml version="1.0" encoding="' . get_bloginfo('charset') . "\" ?>\n";
		echo "<WONDERPLUGINCAROUSEL>\r\n";
		foreach($data as $row)
		{
			if (empty($row))
				continue;

			echo "<ID>" . intval($row["id"]) . "</ID>\r\n";
			echo "<NAME>" . $this->xml_cdata($row["name"]) . "</NAME>\r\n";
			echo "<DATA>" . $this->xml_cdata($row["data"]) . "</DATA>\r\n";
			echo "<TIME>" . $this->xml_cdata($row["time"]) . "</TIME>\r\n";
			echo "<AUTHORID>" . $this->xml_cdata($row["authorid"]) . "</AUTHORID>\r\n";
		}
		echo '</WONDERPLUGINCAROUSEL>';

		fclose($output);
		exit;
	}

	function get_list_item_data($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		return $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) , ARRAY_A);
	}

	function find_id_by_name($itemname)
	{
		$list = $this->get_list_data();

		$id = null;

		foreach($list as $item)
		{
			if (strcasecmp($item['name'], $itemname) == 0)
			{
				$id = $item['id'];
				break;
			}
		}

		return $id;
	}

	function get_multilingual_slide_text($slide, $attr, $currentlang) {

		$result = !empty($slide->{$attr}) ? $slide->{$attr} : '';

		if ($this->multilingual && !empty($slide->langs) )		
		{
			$langs = json_decode($slide->langs, true);
			if ( !empty($langs) && array_key_exists($currentlang, $langs) && array_key_exists($attr, $langs[$currentlang]))
			{
				$result = $langs[$currentlang][$attr];
			}
		}

		return $result;
	}

	function generate_socialmedia_code($slide) {

		$socialmedia = '';

		try
		{
			$sociallist = json_decode($slide->socialmedia, true);
		}
		catch (Exception $e) {
		}

		$socialtarget = empty($slide->socialmediatarget) ? '' : (' target="' . $slide->socialmediatarget . '"');
		$socialrotate = (isset($slide->socialmediarotate) && (strtolower($slide->socialmediarotate) === 'true')) ? ' amazingcarousel-socialmedia-rotate' : '';

		if (!empty($sociallist))
		{
			foreach($sociallist as $social)
			{
				$socialurl = ($social['name'] == 'mail' && substr( $social['url'], 0, 7 ) !== 'mailto:') ? ('mailto:' . $social['url']) : $social['url'];
				$socialmedia .= '<div class="amazingcarousel-socialmedia-button"><a' . $socialtarget . ' href="' . $socialurl . '">' .
						'<div class="amazingcarousel-socialmedia-icon' . $socialrotate . ' mh-icon-' . $social['name'] . '" style="background-color:' . $this->get_socialmedia_color($social['name']). ';"></div>'. '</a></div>';
			}
		}

		return $socialmedia;
	}

	function generate_button_code($id, $data, $slide, $socialmedia) {

		$button_code = '';

		if (isset($slide->button) && strlen($slide->button) > 0)
		{
			if (isset($slide->buttonlightbox) && strtolower($slide->buttonlightbox) === 'true')
			{
				$button_code .= $this->generate_lightbox_code($id, $data, $slide, $socialmedia);
			}
			else if ($slide->buttonlink && strlen($slide->buttonlink) > 0)
			{
				$button_code .= '<a href="' . $slide->buttonlink . '"';
				if ($slide->buttonlinktarget && strlen($slide->buttonlinktarget) > 0)
					$button_code .= ' target="' . $slide->buttonlinktarget . '"';
			}

			if ( (isset($slide->buttonlightbox) && strtolower($slide->buttonlightbox) === 'true')  || ($slide->buttonlink && strlen($slide->buttonlink) > 0) )
			{
				if (isset($slide->title) && strlen($slide->title) > 0)
					$button_code .= ' data-title="' . $this->eacape_html_quotes($slide->title) . '"';

				if (isset($slide->description) && strlen($slide->description) > 0)
					$button_code .= ' data-description="' .  $this->eacape_html_quotes($slide->description) . '"';

				if (isset($data->lightboxaddsocialmedia) && (strtolower($data->lightboxaddsocialmedia) === 'true'))
					$button_code .= ' data-socialmedia="' .  $this->eacape_html_quotes($socialmedia) . '"';

				$button_code .= '>';
			}

			$button_code .= '<button class="' . $slide->buttoncss . '">' . $slide->button . '</button>';

			if ( (isset($slide->buttonlightbox) && strtolower($slide->buttonlightbox) === 'true')  || ($slide->buttonlink && strlen($slide->buttonlink) > 0) )
			{
				$button_code .= '</a>';
			}
		}

		return $button_code;
	}

	function generate_lightbox_code($id, $data, $slide, $socialmedia) {

		$image_code = '<a';
		if (!empty($data->aextraprops))
			$image_code .= ' ' . $data->aextraprops;
		$image_code .= ' href="';
		if ($slide->type == 0)
		{
			$image_code .= $slide->image;
		}
		else if ($slide->type == 11)
		{
			$image_code .= $slide->pdf;
		}
		else if ($slide->type == 1)
		{
			$image_code .= $slide->mp4;
			if ($slide->webm)
				$image_code .= '" data-webm="' . $slide->webm;
		}
		else if ($slide->type == 2 || $slide->type == 3 || $slide->type == 10)
		{
			$image_code .= $slide->video;
		}

		if ($slide->title && strlen($slide->title) > 0)
			$image_code .= '" data-title="' . $this->eacape_html_quotes($slide->title);

		if ($slide->description && strlen($slide->description) > 0)
			$image_code .= '" data-description="' . $this->eacape_html_quotes($slide->description);

		if (isset($data->lightboxaddsocialmedia) && (strtolower($data->lightboxaddsocialmedia) === 'true'))
			$image_code .= '" data-socialmedia="' . $this->eacape_html_quotes($socialmedia);

		if ($slide->lightboxsize)
			$image_code .= '" data-width="' .  $slide->lightboxwidth . '" data-height="' .  $slide->lightboxheight;

		$image_code .= '" data-thumbnail="' . $slide->thumbnail;

		$image_code .= '" class="wondercarousellightbox wondercarousellightbox-' . $id . '"';
		if ( !isset($data->lightboxnogroup) || strtolower($data->lightboxnogroup) !== 'true' )
			$image_code .= ' data-group="wondercarousellightbox-' . $id . '"';

		if ($slide->type == 10)
			$image_code .= ' data-ytplaylist=1';

		if (!isset($data->addvideomediatype) || (strtolower($data->addvideomediatype) === 'true'))
		{
			switch($slide->type)
			{
				case 0:
					$image_code .= ' data-mediatype=0';
					break;
				case 1:
					$image_code .= ' data-mediatype=2';
					break;
				case 2:
					$image_code .= ' data-mediatype=3';
					break;
				case 3:
					$image_code .= ' data-mediatype=4';
					break;
			}
		}
		return $image_code;
	}

	function generate_body_code($id, $itemname, $has_wrapper, $inline_content, $attributes) {

		if ( !isset($id) )
		{
			if ( isset($itemname) )
			{
				$id = $this->find_id_by_name($itemname);
			}
		}

		if ( !isset($id) )
		{
			return '<p>Please specify a valid carousel id or name.</p>';
		}

		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		if ( !$this->is_db_table_exists() )
		{
			return '<p>The specified carousel does not exist.</p>';
		}

		$sanitizehtmlcontent = get_option( 'wonderplugin_carousel_sanitizehtmlcontent', 1 );

		$ret = "";
		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$data = str_replace('\\\"', '"', $item_row->data);
			$data = str_replace("\\\'", "'", $data);
			$data = str_replace("\\\\", "\\", $data);

			$data = json_decode(trim($data));

			if ( isset($data->publish_status) && ($data->publish_status === 0) )
			{
				return '<p>The specified carousel is trashed.</p>';
			}

			// attributes in shortcode
			if (!empty($attributes))
			{
				foreach($attributes as $key => $value)
				{
					$data->{$key} = $value;
				}
			}

			if ($sanitizehtmlcontent == 1)
			{
				add_filter('safe_style_css', 'wonderplugin_carousel_css_allow');
				add_filter('wp_kses_allowed_html', 'wonderplugin_carousel_tags_allow', 'post');
				foreach($data as &$value)
				{
					if ( is_string($value) )
						$value = wp_kses_post($value);
				}
				remove_filter('wp_kses_allowed_html', 'wonderplugin_carousel_tags_allow', 'post');
				remove_filter('safe_style_css', 'wonderplugin_carousel_css_allow');
			}

			if (isset($data->customcss) && strlen($data->customcss) > 0)
			{
				$customcss = str_replace("\r", " ", $data->customcss);
				$customcss = str_replace("\n", " ", $customcss);
				$customcss = str_replace("CAROUSELID", $id, $customcss);
				$ret .= '<style type="text/css">' . $customcss . '</style>';
			}

			if (isset($data->skincss) && strlen($data->skincss) > 0)
			{
				$skincss = str_replace("\r", " ", $data->skincss);
				$skincss = str_replace("\n", " ", $skincss);

				if (strpos($skincss, 'amazingcarousel-socialmedia-button') === false)
				{
					$skincss .= ' .amazingcarousel-socialmedia-button { display: inline-block; margin: 4px; }.amazingcarousel-socialmedia-button a { box-shadow: none; }.amazingcarousel-socialmedia-icon { display:table-cell; width:32px; height:32px; font-size:18px; border-radius:50%; color:#fff; vertical-align:middle; text-align:center; cursor:pointer; padding:0;}.amazingcarousel-socialmedia-rotate { transition: transform .4s ease-in; } .amazingcarousel-socialmedia-rotate:hover { transform: rotate(360deg); }';
				}

				$skincss = str_replace('#amazingcarousel-CAROUSELID',  '#wonderplugincarousel-' . $id, $skincss);
				$ret .= '<style type="text/css">' . $skincss . '</style>';
			}

			if (isset($data->lightboxadvancedoptions) && strlen($data->lightboxadvancedoptions) > 0)
			{
				$ret .= '<div id="wpcarousellightbox_advanced_options_' . $id . '" ' . stripslashes($data->lightboxadvancedoptions) . ' ></div>';
			}

			if ($has_wrapper)
				$ret .= '<div class="wonderplugincarousel-container" id="wonderplugincarousel-container-' . $id . '" style="max-width:' . ( ( isset($data->fullwidth) && (strtolower($data->fullwidth) === 'true') ) ? '100%;' : ($data->width * $data->visibleitems . 'px;')) . 'margin:0 auto;padding:0 60px;">';
			else
				$ret .= '<div class="wonderplugincarousel-container" id="wonderplugincarousel-container-' . $id . '">';

			$has_woocommerce = false;
			if (class_exists('WooCommerce') && isset($data->addwoocommerceclass) && (strtolower($data->addwoocommerceclass) === 'true'))
			{
				$has_custom = false;
				if (isset($data->slides) && count($data->slides) > 0)
				{
					foreach ($data->slides as $index => $slide)
					{
						if ($slide->type == 7)
						{
							$has_custom = true;
							break;
						}
					}
				}
				if ($has_custom)
					$has_woocommerce = true;
			}

			$currentlang = $this->multilingual ? (!empty($data->lang) ? $data->lang : $this->currentlang) : null;

			// div data tag
			$ret .= '<div class="wonderplugincarousel' . ($has_woocommerce ? ' woocommerce' : '') . '" id="wonderplugincarousel-' . $id . '" data-carouselid="' . $id . '" data-width="' . $data->width . '" data-height="' . $data->height . '" data-skin="' . $data->skin . '"';

			if (isset($data->dataoptions) && strlen($data->dataoptions) > 0)
			{
				$ret .= ' ' . stripslashes($data->dataoptions);
			}

			$boolOptions = array('addpreloading', 'multiplebyrow', 'showimgtitle','sameheight', 'sameheightresponsive', 'fullwidth', 'centerimage', 'fitimage', 'fitcenterimage', 'fixaspectratio', 'autoplay', 'random', 'autoplayvideo', 'circular', 'pauseonmouseover', 'continuous', 'responsive', 'showhoveroverlay', 'showhoveroverlayalways', 'hidehoveroverlayontouch', 'lightboxresponsive', 'lightboxshownavigation', 'lightboxnogroup', 'lightboxshowtitle', 'lightboxshowdescription', 'lightboxaddsocialmedia', 'usescreenquery', 'donotinit', 'addinitscript', 'doshortcodeontext',
					'lightboxshowsocial', 'lightboxshowemail', 'lightboxshowfacebook', 'lightboxshowtwitter', 'lightboxshowpinterest', 'lightboxsocialrotateeffect', 'donotcircularforless', 'deferloading', 'enablelazyload', 'usebase64',
					'hidecontainerbeforeloaded', 'hidecontaineroninit', 'lightboximagekeepratio', 'showplayvideo', 'triggerresize', 'lightboxfullscreenmode', 'lightboxcloseonoverlay', 'lightboxvideohidecontrols', 'lightboxautoslide', 'lightboxshowtimer', 'lightboxshowplaybutton', 'lightboxalwaysshownavarrows', 'lightboxshowtitleprefix');
			foreach ( $boolOptions as $key )
			{
				if (isset($data->{$key}) )
					$ret .= ' data-' . $key . '="' . ((strtolower($data->{$key}) === 'true') ? 'true': 'false') .'"';
			}

			if ( class_exists('WonderPlugin_PDF_Plugin') )
			{
				global $wonderplugin_pdf_plugin;

				$pdfjsengine = $wonderplugin_pdf_plugin->get_pdf_engine();

				$ret .= ' data-lightboxenablepdfjs="' . 'true' . '"';
				$ret .= ' data-lightboxpdfjsengine="' . $pdfjsengine . '"';
			}

			$valOptions = array('preloadingimage', 'spacing', 'rownumber', 'visibleitems', 'arrowstyle', 'arrowimage', 'arrowwidth', 'arrowheight', 'navstyle', 'navimage', 'navwidth', 'navheight', 'navspacing', 'hoveroverlayimage', 'lightboxthumbwidth', 'lightboxthumbheight', 'lightboxthumbtopmargin', 'lightboxthumbbottommargin', 'lightboxbarheight', 'lightboxtitlebottomcss', 'lightboxdescriptionbottomcss', 'continuousduration',
					'autoplaydir', 'scrollmode', 'interval', 'transitionduration', 'lightboxtitlestyle', 'lightboximagepercentage', 'lightboxdefaultvideovolume', 'lightboxoverlaybgcolor', 'lightboxoverlayopacity', 'lightboxbgcolor', 'lightboxtitleprefix', 'lightboxtitleinsidecss', 'lightboxdescriptioninsidecss',
					'playvideoimage', 'playvideoimagepos', 'imgtitle', 'circularlimit', 'deferloadingdelay',
					'lightboxsocialposition', 'lightboxsocialpositionsmallscreen', 'lightboxsocialdirection', 'lightboxsocialbuttonsize', 'lightboxsocialbuttonfontsize',
					'sameheightmediumscreen', 'sameheightmediumheight', 'sameheightsmallscreen', 'sameheightsmallheight', 'triggerresizedelay', 'lightboxslideinterval', 'lightboxtimerposition', 'lightboxtimerheight:', 'lightboxtimercolor', 'lightboxtimeropacity', 'lightboxbordersize', 'lightboxborderradius');
			foreach ( $valOptions as $key )
			{
				if (isset($data->{$key}) )
					$ret .= ' data-' . $key . '="' . $data->{$key} . '"';
			}

			// screen query
			if (isset($data->screenquery))
				$ret .= " data-screenquery='" . preg_replace('/\s+/', ' ', trim($data->screenquery))   . "'";
			else
				$ret .= " data-screenquery='{ \"mobile\": { \"screenwidth\": 480, \"visibleitems\": 1 } }'";

			$ret .= ' data-jsfolder="' . WONDERPLUGIN_CAROUSEL_URL . 'engine/"';

			if ($data->direction == 'vertical')
				$totalwidth = $data->width;
			else
				$totalwidth = $data->width * $data->visibleitems;

			if (strtolower($data->responsive) === 'true')
				$ret .= ' style="display:none;position:relative;margin:0 auto;width:100%;max-width:' . $totalwidth . 'px;"';
			else
				$ret .= ' style="display:none;position:relative;margin:0 auto;width:' . $totalwidth . 'px;"';

			$ret .= ' >';

			if ( !isset($data->rownumber) || !is_int($data->rownumber) || $data->rownumber < 1)
				$data->rownumber = 1;

			// check inline object
			if (!empty($inline_content))
			{
				$ret .= $inline_content;
			}

			if (empty($inline_content) && isset($data->slides) && count($data->slides) > 0)
			{
				$ret .= '<div class="amazingcarousel-list-container" style="overflow:hidden;">';
				$ret .= '<ul class="amazingcarousel-list">';

				$count = 0;

				$items = array();
				foreach ($data->slides as $slide)
				{
					if ($slide->type == 12)
					{
						if (!empty($data->importfolder))
						{
							$slide->folder = $data->importfolder;
						}
						$items = array_merge($items, $this->get_items_from_folder($slide));
					}
					else
					{
						$items[] = $slide;
					}
				}

				foreach ($items as $index => $slide)
				{
					if ($sanitizehtmlcontent == 1)
					{
						add_filter('safe_style_css', 'wonderplugin_carousel_css_allow');
						add_filter('wp_kses_allowed_html', 'wonderplugin_carousel_tags_allow', 'post');
						foreach($slide as &$value)
						{
							if ( is_string($value) )
								$value = wp_kses_post($value);
						}
						remove_filter('wp_kses_allowed_html', 'wonderplugin_carousel_tags_allow', 'post');
						remove_filter('safe_style_css', 'wonderplugin_carousel_css_allow');
					}

					$boolOptions = array('lightbox', 'displaythumbnail', 'lightboxsize', 'weblinklightbox');
					foreach ( $boolOptions as $key )
					{
						if (isset($slide->{$key}) )
							$slide->{$key} = ((strtolower($slide->{$key}) === 'true') ? true: false);
					}

					if ($slide->type == 6)
					{
						$items = $this->get_post_items($slide);
						$ret .= $this->create_post_code($items, $data, $id);
					}
					else if ($slide->type == 7)
					{
						$items = $this->get_custom_post_items($slide);
						$ret .= $this->create_custom_post_code($items, $data, $id);
					}
					else if ($slide->type == 8)
					{
						$items = $this->get_page_item($slide);
						$ret .= $this->create_page_code($items, $data, $id);
					}
					else if ($slide->type == 13)
					{
						if ($count == 0)
							$ret .= '<li class="amazingcarousel-item">';
						else if ($count % $data->rownumber == 0)
							$ret .= '</li><li class="amazingcarousel-item">';

						$count++;

						$ret .= '<div class="amazingcarousel-item-container">';
						$ret .= $slide->htmlcode;
						$ret .= '</div>';

					}
					else
					{
						if ($slide->type == 10)
						{
							if ($count > 0)
								$ret .= '</li>';

							$ret .= '<li class="amazingcarousel-item"';
							$slide->image = '__IMAGE__';
							$slide->thumbnail = '__THUMBNAIL__';
							$slide->video = '__VIDEO__';
							$slide->title = '__TITLE__';
							$slide->description = '__DESCRIPTION__';
							$ret .= ' data-youtubeapikey="' . $slide->youtubeapikey . '" data-youtubeplaylistid="' . $slide->youtubeplaylistid . '" data-youtubeplaylistmaxresults="' . $slide->youtubeplaylistmaxresults . '"';
							$ret .= '>';
						}
						else
						{
							if ($count == 0)
								$ret .= '<li class="amazingcarousel-item">';
							else if ($count % $data->rownumber == 0)
								$ret .= '</li><li class="amazingcarousel-item">';
						}

						$count++;

						if ($this->multilingual && $currentlang != $this->defaultlang)
						{
							$slide->title = $this->get_multilingual_slide_text($slide, 'title', $currentlang);
							$slide->description = $this->get_multilingual_slide_text($slide, 'description', $currentlang);
							$slide->alt = $this->get_multilingual_slide_text($slide, 'alt', $currentlang);
							$slide->button = $this->get_multilingual_slide_text($slide, 'button', $currentlang);
						}

						if ( isset($data->doshortcodeontext) && (strtolower($data->doshortcodeontext) === 'true') )
						{
							if ($slide->title && strlen($slide->title) > 0)
								$slide->title = do_shortcode($slide->title);

							if ($slide->description && strlen($slide->description) > 0)
								$slide->description = do_shortcode($slide->description);

							if ($slide->alt && strlen($slide->alt) > 0)
								$slide->alt = do_shortcode($slide->alt);
						}

						$socialmedia = empty($slide->socialmedia) ? '' : $this->generate_socialmedia_code($slide);

						$ret .= '<div class="amazingcarousel-item-container">';

						$image_code = '';
						if ( isset($slide->lightbox) && $slide->lightbox )
						{
							$image_code .= $this->generate_lightbox_code($id, $data, $slide, $socialmedia);
							$image_code .= '>';
						}
						else if ($slide->weblink && strlen($slide->weblink) > 0)
						{
							$image_code .= '<a';
							if (!empty($data->aextraprops))
								$image_code .= ' ' . $data->aextraprops;
							$image_code .= ' href="' . $slide->weblink . '"';
							if (isset($slide->clickhandler) && strlen($slide->clickhandler) > 0)
								$image_code .= ' onclick="' . str_replace('"', '&quot;', $slide->clickhandler) . '"';
							if ($slide->linktarget && strlen($slide->linktarget) > 0)
								$image_code .= ' target="' . $slide->linktarget . '"';
							if ( isset($slide->weblinklightbox) && $slide->weblinklightbox )
							{
								$image_code .= '" class="wondercarousellightbox wondercarousellightbox-' . $id . '"';
								if ( !isset($data->lightboxnogroup) || strtolower($data->lightboxnogroup) !== 'true' )
									$image_code .= ' data-group="wondercarousellightbox-' . $id . '"';
								if ($slide->lightboxsize)
									$image_code .= ' data-width="' .  $slide->lightboxwidth . '" data-height="' .  $slide->lightboxheight . '"';
							}
							$image_code .= '>';
						}

						$image_code .= '<img class="amazingcarousel-image-img"';

						if (!empty($data->imgextraprops))
							$image_code .= ' ' . $data->imgextraprops;

						if ($slide->type == 10)
						{
							$image_code .= ' data-srcyt="';
						}
						else
						{
							if ((isset($data->deferloading) && (strtolower($data->deferloading) === 'true')) || (isset($data->enablelazyload) && (strtolower($data->enablelazyload) === 'true')))
							{
								if (!isset($data->usebase64) || strtolower($data->usebase64) === 'true')
									$image_code .= ' src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-aclazysrc="';
								else
									$image_code .= ' src="" data-aclazysrc="';
							}
							else
							{
								$image_code .= ' src="';
							}	
						}

						if ( isset($slide->displaythumbnail) && $slide->displaythumbnail )
							$image_code .= $slide->thumbnail . '"';
						else
							$image_code .= $slide->image . '"';

						if ( isset($slide->altusetitle) && (strtolower($slide->altusetitle) === 'false') && isset($slide->alt) )
							$image_code .= ' alt="' . $this->eacape_html_quotes(strip_tags($slide->alt)) . '" data-title="' . $this->eacape_html_quotes($slide->title) . '"';
						else
							$image_code .= ' alt="' . $this->eacape_html_quotes(strip_tags($slide->title)) . '"';

						if ( isset($data->showimgtitle) && (strtolower($data->showimgtitle) === 'true') && isset($data->imgtitle) )
						{
							if ($data->imgtitle == 'title' && isset($slide->title))
								$image_code .= ' title="' . $this->eacape_html_quotes($slide->title) . '"';
							else if ($data->imgtitle == 'description' && isset($slide->description))
								$image_code .= ' title="' . $this->eacape_html_quotes($slide->description) . '"';
							else if ($data->imgtitle == 'alt' && isset($slide->alt))
								$image_code .= ' title="' . $this->eacape_html_quotes($slide->alt) . '"';
						}

						$image_code .= ' data-description="' . $this->eacape_html_quotes($slide->description) . '"';
						if (!$slide->lightbox)
						{
							if ($slide->type == 1)
							{
								$image_code .= ' data-video="' . $slide->mp4 . '"';
								if ($slide->webm)
									$image_code .= ' data-videowebm="' . $slide->webm . '"';
							}
							else if ($slide->type == 2 || $slide->type == 3 || $slide->type == 10)
							{
								$image_code .= ' data-video="' . $slide->video . '"';
							}

							switch($slide->type)
							{
								case 1:
									$image_code .= ' data-videotype=6';
									break;
								case 2:
									$image_code .= ' data-videotype=9';
									break;
								case 3:
									$image_code .= ' data-videotype=10';
									break;
							}
						}
						$image_code .= ' />';

						if ($slide->lightbox || (!$slide->lightbox && $slide->weblink && strlen($slide->weblink) > 0))
						{
							$image_code .= '</a>';
						}

						$title_code = '';
						if ($slide->title && strlen($slide->title) > 0)
							$title_code = $slide->title;

						$description_code = '';
						if ($slide->description && strlen($slide->description) > 0)
							$description_code = $slide->description;

						$skin_template = str_replace('&amp;',  '&', $data->skintemplate);
						$skin_template = str_replace('&lt;',  '<', $skin_template);
						$skin_template = str_replace('&gt;',  '>', $skin_template);

						$skin_template = str_replace('__ID__',  $count, $skin_template);
						$skin_template = str_replace('__IMAGE__',  $image_code, $skin_template);
						$skin_template = str_replace('__TITLE__',  $title_code, $skin_template);
						$skin_template = str_replace('__DESCRIPTION__',  $description_code, $skin_template);

						$skin_template = str_replace('__HREF__',  empty($slide->weblink) ? '' : $slide->weblink, $skin_template);
						$skin_template = str_replace('__CLICKHANDLER__',  empty($slide->clickhandler) ? '' : $slide->clickhandler, $skin_template);
						$skin_template = str_replace('__TARGET__',  empty($slide->linktarget) ? '' : $slide->linktarget, $skin_template);
						$skin_template = str_replace('__SOCIALMEDIA__', $socialmedia, $skin_template);
						$skin_template = str_replace('__BUTTON__', $this->generate_button_code($id, $data, $slide, $socialmedia), $skin_template);

						$ret .= $skin_template;

						$ret .= '</div>';
					}
				}

				if ($count > 0)
					$ret .= '</li>';

				$ret .= '</ul>';
				$ret .= '<div class="amazingcarousel-prev"></div><div class="amazingcarousel-next"></div>';
				$ret .= '</div>';
				$ret .= '<div class="amazingcarousel-nav"></div>';

			}
			if ('F' == 'F')
				$ret .= '<div class="wonderplugin-engine"><a href="http://www.wonderplugin.com/wordpress-carousel/" title="'. get_option('wonderplugin-carousel-engine')  .'">' . get_option('wonderplugin-carousel-engine') . '</a></div>';
			$ret .= '</div>';

			$ret .= '</div>';

			if (isset($data->addinitscript) && strtolower($data->addinitscript) === 'true')
			{
				$ret .= '<script>jQuery(document).ready(function(){jQuery(".wonderplugin-engine").css({display:"none"});jQuery(".wonderplugincarousel").wonderplugincarouselslider({forceinit:true});});</script>';
			}

			if (isset($data->triggerresize) && strtolower($data->triggerresize) === 'true')
			{
				$ret .= '<script>jQuery(document).ready(function(){';
				if ($data->triggerresizedelay > 0)
					$ret .= 'setTimeout(function(){jQuery(window).trigger("resize");},' . $data->triggerresizedelay . ');';
				else
					$ret .= 'jQuery(window).trigger("resize");';
				$ret .= '});</script>';
			}

			if (isset($data->customjs) && strlen($data->customjs) > 0)
			{
				$customjs = str_replace("\r", " ", $data->customjs);
				$customjs = str_replace("\n", " ", $customjs);
				$customjs = str_replace('&lt;',  '<', $customjs);
				$customjs = str_replace('&gt;',  '>', $customjs);
				$customjs = str_replace("CAROUSELID", $id, $customjs);
				$ret .= '<script language="JavaScript">' . $customjs . '</script>';
			}
		}
		else
		{
			$ret = '<p>The specified carousel id does not exist.</p>';
		}
		return $ret;
	}

	function replace_custom_field($postdata, $postmeta, $field, $textlength) {

		$postdata = array_merge($postdata, $postmeta);

		$postdata = apply_filters( 'wonderplugin_carousel_custom_post_field_content', $postdata );

		$result = $field;

		preg_match_all('/\\%(.*?)\\%/s', $field, $matches);

		if (!empty($matches) && count($matches) > 1)
		{
			foreach($matches[1] as $match)
			{
				$replace = '';
				if (array_key_exists($match, $postdata))
				{
					if (is_array($postdata[$match]))
					{
						$replace = implode(' ', $postdata[$match]);
					}
					else
					{
						$replace = $postdata[$match];
					}

					if ($match == 'post_content' || $match == 'post_excerpt')
						$replace = wonderplugin_carousel_wp_trim_words($replace, $textlength);
				}
				$result = str_replace('%' . $match . '%', $replace, $result);
			}
		}

		return $result;
	}

	function get_items_from_folder($slide) {

		$dir = ABSPATH . $slide->folder;

		$items = array();

		if (!is_readable($dir) || !file_exists($dir))
		{
			$item = array(
					'type'			=> 0,
					'image'			=> '',
					'thumbnail'		=> '',
					'displaythumbnail'	=> true,
					'title'			=> 'No permissions to browse the folder or the folder does not exist',
					'description'	=> '',
					'weblink'		=> '',
					'linktarget'	=> '',
					'button'			=> '',
					'buttoncss'			=> '',
					'buttonlightbox'	=> false,
					'buttonlink'		=> '',
					'buttonlinktarget'	=> '',
					'lightbox' 			=> $slide->lightbox,
					'lightboxsize' 		=> $slide->lightboxsize,
					'lightboxwidth' 	=> $slide->lightboxwidth,
					'lightboxheight' 	=> $slide->lightboxheight
			);

			$items[] = (object) $item;

			return $items;
		}

		$exts = explode('|', $slide->imageext);

		$dirurl = get_site_url(). '/' . str_replace(DIRECTORY_SEPARATOR, '/', $slide->folder) . '/';

		if ($slide->sortorder == 'ASC')
			$cdir = scandir($dir);
		else
			$cdir = scandir($dir, 1);

		$usefilenameastitle = isset($slide->usefilenameastitle) && strtolower($slide->usefilenameastitle) === 'true';

		foreach ($cdir as $key => $value)
		{
			if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
			{
				if (preg_match('/(?<!' . $slide->thumbname . '|' . $slide->postername . ')\.(' . $slide->imageext . ')$/i', $value))
				{
					$info = pathinfo($value);
					$thumb = $info['filename'] . $slide->thumbname . '.' . $info['extension'];

					$imageurl = $dirurl . $value;
					$thumburl = (in_array($thumb, $cdir)) ? $dirurl . $thumb : $imageurl;

					$item = array(
							'type'				=> 0,
							'image'				=> $imageurl,
							'thumbnail'			=> $thumburl,
							'displaythumbnail'	=> true,
							'title'				=> $usefilenameastitle ? $info['filename'] : '',
							'description'		=> '',
							'weblink'			=> '',
							'linktarget'		=> '',
							'button'			=> '',
							'buttoncss'			=> '',
							'buttonlightbox'	=> false,
							'buttonlink'		=> '',
							'buttonlinktarget'	=> '',
							'lightbox' 			=> $slide->lightbox,
							'lightboxsize' 		=> $slide->lightboxsize,
							'lightboxwidth' 	=> $slide->lightboxwidth,
							'lightboxheight' 	=> $slide->lightboxheight
					);

					$items[] = (object) $item;
				}
				else if (preg_match('/\.(' . $slide->videoext . ')$/i', $value))
				{
					$info = pathinfo($value);

					$videourl = $dirurl . $value;

					$thumburl = '';
					foreach($exts as $ext)
					{
						$thumb = $info['filename'] . $slide->thumbname . '.' . $ext;

						if (in_array($thumb, $cdir))
						{
							$thumburl = $dirurl . $thumb;
							break;
						}
					}

					$posterurl = '';
					foreach($exts as $ext)
					{
						$poster = $info['filename'] . $slide->postername . '.' . $ext;
						if (in_array($poster, $cdir))
						{
							$posterurl = $dirurl . $poster;
							break;
						}
					}

					if ( empty($thumburl) && !empty($posterurl) )
					{
						$thumburl = $posterurl;
					}
					else if ( empty($posterurl) && !empty($thumburl) )
					{
						$posterurl = $thumburl;
					}

					$item = array(
							'type'				=> 1,
							'mp4'				=> $videourl,
							'webm'				=> '',
							'image'				=> $posterurl,
							'thumbnail'			=> $thumburl,
							'displaythumbnail'	=> true,
							'title'				=> $usefilenameastitle ? $info['filename'] : '',
							'description'		=> '',
							'weblink'			=> '',
							'linktarget'		=> '',
							'button'			=> '',
							'buttoncss'			=> '',
							'buttonlightbox'	=> false,
							'buttonlink'		=> '',
							'buttonlinktarget'	=> '',
							'lightbox' 			=> $slide->lightbox,
							'lightboxsize' 		=> $slide->lightboxsize,
							'lightboxwidth' 	=> $slide->lightboxwidth,
							'lightboxheight' 	=> $slide->lightboxheight
					);

					$items[] = (object) $item;
				}
			}
		}


		// read config.xml file
		$xmlfile = $dir . DIRECTORY_SEPARATOR . 'list.xml';
		if (file_exists($xmlfile) && function_exists("simplexml_load_string"))
		{
			$content = file_get_contents($xmlfile);

			$xml = simplexml_load_string($content);

			if ($xml && isset($xml->item))
			{
				foreach($xml->item as $xmlitem)
				{
					if (isset($xmlitem->image) && (strpos(strtolower($xmlitem->image), 'http://') !== 0) && (strpos(strtolower($xmlitem->image), 'https://') !== 0) && (strpos(strtolower($xmlitem->image), '/') !== 0))
					{
						$xmlitem->image = $dirurl . $xmlitem->image;

						foreach($items as &$item)
						{
							if (isset($item->image) && (strtolower($item->image) == strtolower($xmlitem->image)))
							{
								unset($xmlitem->image);

								foreach ($xmlitem as $key => $value)
								{
									$item->{$key} = $value;
								}

								break;
							}
						}
					}
					else
					{
						$new = array(
									'type'				=> 0,
									'image'				=> '',
									'thumbnail'			=> '',
									'displaythumbnail'	=> true,
									'title'				=> '',
									'description'		=> '',
									'weblink'			=> '',
									'linktarget'		=> '',
									'button'			=> '',
									'buttoncss'			=> '',
									'buttonlightbox'	=> false,
									'buttonlink'		=> '',
									'buttonlinktarget'	=> '',
									'lightbox' 			=> $slide->lightbox,
									'lightboxsize' 		=> $slide->lightboxsize,
									'lightboxwidth' 	=> $slide->lightboxwidth,
									'lightboxheight' 	=> $slide->lightboxheight
							);

						foreach ($xmlitem as $key => $value)
						{
							$new[$key] = $value;
						}

						$items[] = (object) $new;
					}
				}
			}
		}

		return $items;
	}

	function get_custom_post_items($options) {

		global $post;

		$items = array();

		$args = array(
					'post_type' 		=> $options->customposttype,
					'posts_per_page'	=> $options->postnumber,
					'post_status' 	=> 'publish'
				);

		if (isset($options->postdaterange) && (strtolower($options->postdaterange) === 'true') && isset($options->postdaterangeafter) )
		{
			$args['date_query'] = array(
					'after' => date('Y-m-d', strtotime('-' . $options->postdaterangeafter . ' days'))
				);
		}
		else if (isset($options->postdatefromto) && (strtolower($options->postdatefromto) === 'true'))
		{
			$args['date_query'] = array(
					'after' => array('year' => $options->postdatefromyear, 'month' => $options->postdatefrommonth, 'day' => $options->postdatefromday),
					'before' => array('year' => $options->postdatetoyear, 'month' => $options->postdatetomonth, 'day' => $options->postdatetoday),
					'inclusive' => true
			);
		}

		$taxonomytotal = 0;

		$tax_query = array();

		for ($i = 0; ; $i++)
		{
			if (isset($options->{'taxonomy' . $i}) && isset($options->{'term' . $i}) && ($options->{'taxonomy' . $i} != '-1') && ($options->{'term' . $i} != '-1') )
			{
				$taxonomytotal++;
				$tax_query[] = array(
						'taxonomy' => $options->{'taxonomy' . $i},
						'field'    => 'slug',
						'terms'    => $options->{'term' . $i}
				);
			}
			else
			{
				break;
			}
		}

		if ($taxonomytotal > 1)
		{
			$tax_query['relation'] = $options->taxonomyrelation;
		}

		if ($taxonomytotal > 0)
		{
			$args['tax_query'] = $tax_query;
		}

		if (isset($options->postorderbyorder))
		{
			$args['order'] = $options->postorderbyorder;
		}

		if (!empty($options->postorderby))
		{
			$args['orderby'] = $options->postorderby;
		}

		// woocommerce meta query
		if ( class_exists('WooCommerce') && ((isset($options->metatotalsales) && (strtolower($options->metatotalsales) === 'true')) || (isset($options->metafeatured) && (strtolower($options->metafeatured) === 'true'))) )
		{
			$meta_query = array();

			if (isset($options->metatotalsales) && (strtolower($options->metatotalsales) === 'true'))
			{
				$meta_query[] = array(
						'key'       => 'total_sales',
						'value'     => '0',
						'compare'   => '>'
					);

				$args['orderby'] = 'total_sales';
			}

			if (isset($options->metafeatured) && (strtolower($options->metafeatured) === 'true'))
			{
				$meta_query[] = array(
						'key'       => '_featured',
            			'value'     => 'yes',
            			'compare'   => '='
					);
			}

			if ( (isset($options->metatotalsales) && (strtolower($options->metatotalsales) === 'true')) && (isset($options->metafeatured) && (strtolower($options->metafeatured) === 'true')) )
			{
				$meta_query['relation'] = $options->metarelation;
			}

			$meta_query = apply_filters( 'wonderplugin_carousel_modify_custom_post_meta_query', $meta_query );

			$args['meta_query'] = $meta_query;
		}

		$query = new WP_Query($args);
		if ($query->have_posts())
		{
			while ( $query->have_posts() )
			{
				$query->the_post();

				if ($post)
				{
					$postdata = get_object_vars($post);

					$featured_image = '';
					if (has_post_thumbnail($postdata['ID']))
					{
						$featured_image_size = (!empty($options->customfeaturedimagesize)) ? $options->customfeaturedimagesize : 'full';
						$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id($postdata['ID']), $featured_image_size);
						$featured_image = $attachment_image[0];
					}
					$postdata['featured_image'] = $featured_image;

					$postmeta = get_post_meta($postdata['ID']);

					if (class_exists('WooCommerce') && isset($postdata['ID']))
					{
						global $woocommerce;

						$is_woocommerce3 = version_compare( $woocommerce->version, '3.0', ">=");

						$product = wc_get_product($postdata['ID']);
						if ($product)
						{
							$postmeta['wc_price_html'] = $product->get_price_html();
							$postmeta['wc_price'] = wc_price( $product->get_price() );
							$postmeta['wc_regular_price'] = wc_price( $product->get_regular_price() );
							$postmeta['wc_sale_price'] = wc_price( $product->get_sale_price() );
							$postmeta['wc_rating_html'] = $is_woocommerce3 ? wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() ) : $product->get_rating_html();
							$postmeta['wc_review_count'] = $product->get_review_count();
							$postmeta['wc_rating_count'] = $product->get_rating_count();
							$postmeta['wc_average_rating'] = $product->get_average_rating();
							$postmeta['wc_total_sales'] = (int) get_post_meta( $postdata['ID'], 'total_sales', true );

							if (method_exists($product,'get_category_ids'))
							{
								$cat_ids = $product->get_category_ids();
								$cat_index = 0;

								foreach($cat_ids as $cat_id)
								{
									if( $term = get_term_by( 'id', $cat_id, 'product_cat' ) ){

										if ($cat_index == 0)
										{
											$postmeta['wc_product_cat_id'] = $cat_id;
											$postmeta['wc_product_cat_name'] = $term->name;
											$postmeta['wc_product_cat_slug'] = $term->slug;
											$postmeta['wc_product_cat_link'] = get_term_link( $term );
										}

										$postmeta['wc_product_cat_id' . $cat_index] = $cat_id;
										$postmeta['wc_product_cat_name' . $cat_index] = $term->name;
										$postmeta['wc_product_cat_slug' . $cat_index] = $term->slug;
										$postmeta['wc_product_cat_link' . $cat_index] = get_term_link( $term );

										$cat_index++;
									}
								}
							}
						}
					}

					$postlink = get_permalink($postdata['ID']);
					$postdata['post_link'] = $postlink;

					$title = $this->replace_custom_field($postdata, $postmeta, $options->titlefield, $options->textlength);
					$description = $this->replace_custom_field($postdata, $postmeta, $options->descriptionfield, $options->textlength);
					$image = $this->replace_custom_field($postdata, $postmeta, $options->imagefield, $options->textlength);

					$post_item = array(
							'type'					=> 7,
							'image'					=> $image,
							'thumbnail'				=> $image,
							'title'					=> $title,
							'description'			=> $description,
							'postlink'				=> $postlink,
							'datetime'				=> $postdata['post_date'],
							'date'					=> date('Y-m-d', strtotime($postdata['post_date'])),
							'titlelink'				=> (strtolower($options->titlelink) === 'true'),
							'imageaction'			=> (strtolower($options->imageaction) === 'true'),
							'imageactionlightbox'	=> (strtolower($options->imageactionlightbox) === 'true'),
							'openpostinlightbox'		=> (strtolower($options->openpostinlightbox) === 'true'),
							'postlightboxsize'		=> (strtolower($options->postlightboxsize) === 'true'),
							'postlightboxwidth'		=> $options->postlightboxwidth,
							'postlightboxheight'	=> $options->postlightboxheight,
							'postlinktarget'		=> $options->postlinktarget
						);

					$items[] = (object) $post_item;
				}

			}
			wp_reset_postdata();
		}

		if (isset($options->postorder) && ($options->postorder == 'ASC'))
			$items = array_reverse($items);

		$items = apply_filters( 'wonderplugin_carousel_modify_custom_post_items', $items );

		return $items;
	}

	function eacape_html_quotes($str) {

		$result = str_replace("<", "&lt;", $str);
		$result = str_replace('>', '&gt;', $result);
		$result = str_replace("\'", "&#39;", $result);
		$result = str_replace('\"', '&quot;', $result);
		$result = str_replace("'", "&#39;", $result);
		$result = str_replace('"', '&quot;', $result);
		return $result;
	}

	function create_custom_post_code($slides, $data, $id) {

		$ret = '';

		$count = 0;

		foreach($slides as $slide)
		{
			if ($count == 0)
				$ret .= '<li class="amazingcarousel-item">';
			else if ($count % $data->rownumber == 0)
				$ret .= '</li><li class="amazingcarousel-item">';

			$count++;

			$ret .= '<div class="amazingcarousel-item-container">';

			$skin_template = str_replace('&amp;',  '&', $data->skintemplate);
			$skin_template = str_replace('&lt;',  '<', $skin_template);
			$skin_template = str_replace('&gt;',  '>', $skin_template);

			$image_code = '';

			if ($slide->thumbnail && strlen($slide->thumbnail) > 0)
			{
				if ( $slide->imageaction )
				{
					if ( $slide->imageactionlightbox )
					{
						$image_code .= '<a';
						if (!empty($data->aextraprops))
							$image_code .= ' ' . $data->aextraprops;
						$image_code .= ' href="';
						$image_code .= $slide->image;

						if ($slide->title && strlen($slide->title) > 0)
							$image_code .= '" data-title="' . $this->eacape_html_quotes($slide->title);

						if ($slide->description && strlen($slide->description) > 0)
							$image_code .= '" data-description="' . $this->eacape_html_quotes($slide->description);

						if ( $slide->postlightboxsize )
							$image_code .= '" data-width="' .  $slide->postlightboxwidth . '" data-height="' .  $slide->postlightboxheight;

						$image_code .= '" data-thumbnail="' . $slide->thumbnail;

						$image_code .= '" class="wondercarousellightbox wondercarousellightbox-' . $id . '"';
						if ( !isset($data->lightboxnogroup) || strtolower($data->lightboxnogroup) !== 'true' )
							$image_code .= ' data-group="wondercarousellightbox-' . $id . '"';

						$image_code .= '>';
					}
					else if ($slide->postlink && strlen($slide->postlink) > 0)
					{
						$image_code .= '<a';
						if (!empty($data->aextraprops))
							$image_code .= ' ' . $data->aextraprops;
						$image_code .= ' href="' . $slide->postlink . '"';

						if ( $slide->openpostinlightbox )
						{
							if ( $slide->postlightboxsize )
								$image_code .= '" data-width="' .  $slide->postlightboxwidth . '" data-height="' .  $slide->postlightboxheight;

							$image_code .= '" data-thumbnail="' . $slide->thumbnail;

							$image_code .= '" class="wondercarousellightbox wondercarousellightbox-' . $id . '"';
							if ( !isset($data->lightboxnogroup) || strtolower($data->lightboxnogroup) !== 'true' )
								$image_code .= ' data-group="wondercarousellightbox-' . $id . '"';
						}
						else
						{
							if ($slide->postlinktarget && strlen($slide->postlinktarget) > 0)
								$image_code .= ' target="' . $slide->postlinktarget . '"';
						}

						$image_code .= '>';
					}
				}

				$image_code .= '<img class="amazingcarousel-image-img"';

				if (!empty($data->imgextraprops))
					$image_code .= ' ' . $data->imgextraprops;

				if ((isset($data->deferloading) && (strtolower($data->deferloading) === 'true')) || (isset($data->enablelazyload) && (strtolower($data->enablelazyload) === 'true')))
				{
					if (!isset($data->usebase64) || strtolower($data->usebase64) === 'true')
						$image_code .= ' src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-aclazysrc="' . $slide->thumbnail . '"';
					else
						$image_code .= ' src="" data-aclazysrc="' . $slide->thumbnail . '"';
				}	
				else
				{	
					$image_code .= ' src="' . $slide->thumbnail . '"';
				}

				$image_code .= ' alt="' . $this->eacape_html_quotes(strip_tags($slide->title)) . '"';
				$image_code .= ' data-description="' . $this->eacape_html_quotes($slide->description) . '"';
				$image_code .= ' />';

				if ($slide->imageaction && ($slide->imageactionlightbox || ($slide->postlink && strlen($slide->postlink) > 0)))
				{
					$image_code .= '</a>';
				}
			}

			$posttitle = $slide->title;
			if ($slide->titlelink && $slide->postlink && strlen($slide->postlink) > 0 )
			{
				$posttitle = '<a class="amazingcarousel-posttitle-link" href="' . $slide->postlink . '"';
				if ($slide->postlinktarget && strlen($slide->postlinktarget) > 0)
					$posttitle .= ' target="' . $slide->postlinktarget . '"';
				$posttitle .= '>' . $slide->title . '</a>';
			}

			$skin_template = str_replace('__ID__',  $count, $skin_template);
			$skin_template = str_replace('__IMAGESRC__',  $slide->image, $skin_template);
			$skin_template = str_replace('__IMAGE__',  $image_code, $skin_template);
			$skin_template = str_replace('__TITLE__',  $posttitle, $skin_template);
			$skin_template = str_replace('__DESCRIPTION__',  $slide->description, $skin_template);
			$skin_template = str_replace('__HREF__',  $slide->postlink, $skin_template);
			$skin_template = str_replace('__TARGET__',  $slide->postlinktarget, $skin_template);
			$skin_template = str_replace('__DATETIME__',  $slide->datetime, $skin_template);
			$skin_template = str_replace('__DATE__',  $slide->date, $skin_template);
			$skin_template = str_replace('__BUTTON__',  '', $skin_template);
			$skin_template = str_replace('__SOCIALMEDIA__',  '', $skin_template);

			$ret .= $skin_template;
			$ret .= '</div>';
		}

		if ($count > 0)
			$ret .= '</li>';

		return $ret;
	}

	function get_post_items($options) {

		$posts = array();

		$args = array(
				'numberposts' 	=> $options->postnumber,
				'post_status' 	=> 'publish'
		);

		if (isset($options->selectpostbytags) && !empty($options->posttags))
		{
			$args['tag'] = $options->posttags;
		}

		if (isset($options->postdaterange) && isset($options->postdaterangeafter) && (strtolower($options->postdaterange) === 'true'))
		{
			$args['date_query'] = array(
					'after' => date('Y-m-d', strtotime('-' . $options->postdaterangeafter . ' days'))
			);
		}
		else if (isset($options->postdatefromto) && (strtolower($options->postdatefromto) === 'true'))
		{
			$args['date_query'] = array(
					'after' => array('year' => $options->postdatefromyear, 'month' => $options->postdatefrommonth, 'day' => $options->postdatefromday),
					'before' => array('year' => $options->postdatetoyear, 'month' => $options->postdatetomonth, 'day' => $options->postdatetoday),
					'inclusive' => true
			);
		}

		if ($options->postcategory == -1)
		{
			$posts = wp_get_recent_posts($args);
		}
		else
		{
			if ($options->postcategory != -2)
			{
				$args['category'] = $options->postcategory;
			}

			if (!empty($options->postorderby))
			{
				$args['orderby'] = $options->postorderby;
			}

			$posts = get_posts($args);
		}

		$items = array();

		foreach($posts as $post)
		{
			if (is_object($post))
				$post = get_object_vars($post);

			$thumbnail = '';
			$image = '';
			if ( has_post_thumbnail($post['ID']) )
			{
				$featured_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), $options->featuredimagesize);
				$thumbnail = $featured_thumb[0];

				$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), 'full');
				$image = $featured_image[0];
			}

			$excerpt = $post['post_excerpt'];
			if (empty($excerpt))
			{
				$excerpts = explode( '<!--more-->', $post['post_content'] );
				$excerpt = $excerpts[0];
				$excerpt = strip_tags( str_replace(']]>', ']]&gt;', strip_shortcodes($excerpt)) );
			}
			$excerpt = wonderplugin_carousel_wp_trim_words($excerpt, $options->excerptlength);

			$post_categories = wp_get_post_categories( $post['ID'] );
			$cats = array();
			foreach($post_categories as $cat_id){
					
				$cat = get_category( $cat_id );
				$cats[] = array(
						'id'   => $cat_id,
						'name' => $cat->name,
						'slug' => $cat->slug,
						'link' => get_category_link( $cat_id )
				);
			}
								
			$post_tags = wp_get_post_tags( $post['ID'] );
			$tags = array();
			foreach($post_tags as $tag)
			{
				$tags[] = array(
						'id' 	=> $tag->term_id,
						'name'	=> $tag->name,
						'slug'	=> $tag->slug,
						'link'	=> get_tag_link( $tag->term_id )
				);
			}

			$post_link = get_permalink($post['ID']);
			
			if (!isset($options->posttitlefield))
				$options->posttitlefield = '%post_title%';
				
			if (!isset($options->postdescriptionfield))
				$options->postdescriptionfield = '%post_excerpt%';
			
			
			$postdata = array_merge($post, array(
				'post_excerpt' => $excerpt,
				'post_link' => $post_link
			));
						
			foreach($cats as $catindex => $cat)
			{
				if ($catindex == 0)
				{
					$postdata['%categoryid%'] = $cat['id'];
					$postdata['%categoryname%'] = $cat['name'];
					$postdata['%categoryslug%'] = $cat['slug'];
					$postdata['%categorylink%'] = $cat['link'];
				}
				
				$postdata['%categoryid' . $catindex . '%'] = $cat['id'];
				$postdata['%categoryname' . $catindex . '%'] = $cat['name'];
				$postdata['%categoryslug' . $catindex . '%'] = $cat['slug'];
				$postdata['%categorylink' . $catindex . '%'] = $cat['link'];
			}
			
			foreach($tags as $tagindex => $tag)
			{
				if ($tagindex == 0)
				{
					$postdata['%tagid%'] = $tag['id'];
					$postdata['%tagname%'] = $tag['name'];
					$postdata['%tagslug%'] = $tag['slug'];
					$postdata['%taglink%'] = $tag['link'];
				}
				
				$postdata['%tagid' . $tagindex . '%'] = $tag['id'];
				$postdata['%tagname' . $tagindex . '%'] = $tag['name'];
				$postdata['%tagslug' . $tagindex . '%'] = $tag['slug'];
				$postdata['%taglink' . $tagindex . '%'] = $tag['link'];
			}
			
			$postmeta = get_post_meta($postdata['ID']);

			$title = $this->replace_custom_field($postdata, $postmeta, $options->posttitlefield, $options->excerptlength);
			$description = $this->replace_custom_field($postdata, $postmeta, $options->postdescriptionfield, $options->excerptlength);

			$post_item = array(
					'type'			=> 0,
					'image'			=> $image,
					'thumbnail'		=> $thumbnail,
					'title'			=> $title,
					'posttitle'		=> $title,
					'description'	=> $description,
					'weblink'		=> $post_link,
					'linktarget'	=> $options->postlinktarget,
					'datetime'		=> $post['post_date'],
					'date'			=> date('Y-m-d', strtotime($post['post_date']))
			);

			$post_categories = wp_get_post_categories( $post['ID'] );
			$cats = array();
			foreach($post_categories as $cat_id){

				$cat = get_category( $cat_id );
				$cats[] = array(
						'id'   => $cat_id,
						'name' => $cat->name,
						'slug' => $cat->slug,
						'link' => get_category_link( $cat_id )
					);
			}

			$post_item['categories'] = $cats;

			$post_tags = wp_get_post_tags( $post['ID'] );

			$tags = array();
			foreach($post_tags as $tag)
			{
				$tags[] = array(
						'id' 	=> $tag->term_id,
						'name'	=> $tag->name,
						'slug'	=> $tag->slug,
						'link'	=> get_tag_link( $tag->term_id )
					);
			}

			$post_item['tags'] = $tags;

			if (isset($options->postlightbox))
			{
				$post_item['lightbox'] = $options->postlightbox;
				$post_item['lightboxsize'] = $options->postlightboxsize;
				$post_item['lightboxwidth'] = $options->postlightboxwidth;
				$post_item['lightboxheight'] = $options->postlightboxheight;

				if (isset($options->posttitlelink) && strtolower($options->posttitlelink) === 'true')
				{
					$post_item['posttitle'] = '<a class="amazingcarousel-posttitle-link" href="' . $post_item['weblink'] . '"';
					if (isset($post_item['linktarget']) && strlen($post_item['linktarget']) > 0)
						$post_item['posttitle'] .= ' target="' . $post_item['linktarget'] . '"';
					$post_item['posttitle'] .= '>' . $title . '</a>';
				}
			}

			$items[] = (object) $post_item;
		}

		if (isset($options->postorder) && ($options->postorder == 'ASC'))
			$items = array_reverse($items);

		$items = apply_filters( 'wonderplugin_carousel_modify_post_items', $items );

		return $items;
	}

	function get_array_column($input, $prop) {

		$ret = array();

		foreach($input as $value)
		{
			if (isset($value[$prop]))
			{
				$ret[] = $value[$prop];
			}
		}

		return $ret;
	}

	function create_post_code($slides, $data, $id) {

		$ret = '';

		$count = 0;

		foreach($slides as $slide)
		{
			if ($count == 0)
				$ret .= '<li class="amazingcarousel-item">';
			else if ($count % $data->rownumber == 0)
				$ret .= '</li><li class="amazingcarousel-item">';

			$count++;

			$ret .= '<div class="amazingcarousel-item-container">';

			$skin_template = str_replace('&amp;',  '&', $data->skintemplate);
			$skin_template = str_replace('&lt;',  '<', $skin_template);
			$skin_template = str_replace('&gt;',  '>', $skin_template);

			$image_code = '';

			if ($slide->thumbnail && strlen($slide->thumbnail) > 0)
			{
				if ( isset($slide->lightbox) && strtolower($slide->lightbox) === 'true' )
				{
					$image_code .= '<a';
					if (!empty($data->aextraprops))
						$image_code .= ' ' . $data->aextraprops;
					$image_code .= ' href="';
					$image_code .= $slide->image;

					if ($slide->title && strlen($slide->title) > 0)
						$image_code .= '" data-title="' . $this->eacape_html_quotes($slide->title);

					if ($slide->description && strlen($slide->description) > 0)
						$image_code .= '" data-description="' . $this->eacape_html_quotes($slide->description);

					if ( isset($slide->lightboxsize) && strtolower($slide->lightboxsize) === 'true' )
						$image_code .= '" data-width="' .  $slide->lightboxwidth . '" data-height="' .  $slide->lightboxheight;

					$image_code .= '" data-thumbnail="' . $slide->thumbnail;

					$image_code .= '" class="wondercarousellightbox wondercarousellightbox-' . $id . '"';
					if ( !isset($data->lightboxnogroup) || strtolower($data->lightboxnogroup) !== 'true' )
						$image_code .= ' data-group="wondercarousellightbox-' . $id . '"';

					$image_code .= '>';
				}
				else if ($slide->weblink && strlen($slide->weblink) > 0)
				{
					$image_code .= '<a';
					if (!empty($data->aextraprops))
						$image_code .= ' ' . $data->aextraprops;
					$image_code .= ' href="' . $slide->weblink . '"';
					if ($slide->linktarget && strlen($slide->linktarget) > 0)
						$image_code .= ' target="' . $slide->linktarget . '"';
					$image_code .= '>';
				}

				$image_code .= '<img class="amazingcarousel-image-img"';

				if (!empty($data->imgextraprops))
					$image_code .= ' ' . $data->imgextraprops;

				if ((isset($data->deferloading) && (strtolower($data->deferloading) === 'true')) || (isset($data->enablelazyload) && (strtolower($data->enablelazyload) === 'true')))
				{	
					if (!isset($data->usebase64) || strtolower($data->usebase64) === 'true')
						$image_code .= ' src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-aclazysrc="' . $slide->thumbnail . '"';
					else
						$image_code .= ' src="" data-aclazysrc="' . $slide->thumbnail . '"';
				}
				else
				{	
					$image_code .= ' src="' . $slide->thumbnail . '"';
				}

				$image_code .= ' alt="' . $this->eacape_html_quotes(strip_tags($slide->title)) . '"';
				$image_code .= ' data-description="' . $this->eacape_html_quotes($slide->description) . '"';
				$image_code .= ' />';

				if ((isset($slide->lightbox) && strtolower($slide->lightbox) === 'true') || ($slide->weblink && strlen($slide->weblink) > 0))
				{
					$image_code .= '</a>';
				}
			}

			$skin_template = str_replace('__ID__',  $count, $skin_template);
			$skin_template = str_replace('__IMAGE__',  $image_code, $skin_template);
			$skin_template = str_replace('__TITLE__',  $slide->posttitle, $skin_template);
			$skin_template = str_replace('__DESCRIPTION__',  $slide->description, $skin_template);
			$skin_template = str_replace('__HREF__',  $slide->weblink, $skin_template);
			$skin_template = str_replace('__TARGET__',  $slide->linktarget, $skin_template);
			$skin_template = str_replace('__DATETIME__',  $slide->datetime, $skin_template);
			$skin_template = str_replace('__DATE__',  $slide->date, $skin_template);
			$skin_template = str_replace('__BUTTON__',  '', $skin_template);
			$skin_template = str_replace('__SOCIALMEDIA__',  '', $skin_template);

			if ( isset($slide->categories) )
			{
				foreach($slide->categories as $catindex => $cat)
				{
					if ($catindex == 0)
					{
						$skin_template = str_replace('__CATEGORYID__',  $cat['id'], $skin_template);
						$skin_template = str_replace('__CATEGORYNAME__',  $cat['name'], $skin_template);
						$skin_template = str_replace('__CATEGORYSLUG__',  $cat['slug'], $skin_template);
						$skin_template = str_replace('__CATEGORYLINK__',  $cat['link'], $skin_template);
					}

					$skin_template = str_replace('__CATEGORYID' . $catindex . '__',  $cat['id'], $skin_template);
					$skin_template = str_replace('__CATEGORYNAME' . $catindex . '__',  $cat['name'], $skin_template);
					$skin_template = str_replace('__CATEGORYSLUG' . $catindex . '__',  $cat['slug'], $skin_template);
					$skin_template = str_replace('__CATEGORYLINK' . $catindex . '__',  $cat['link'], $skin_template);
				}

				$skin_template = preg_replace('/__CATEGORYNAME\[(.*)\]__/', implode('$1', $this->get_array_column($slide->categories, 'name')), $skin_template);

				if ( preg_match('/__CATEGORYNAMELINK\[(.*)\]\{(.*)\}__/', $skin_template) )
				{
					$replacement = '';
					foreach($slide->categories as $catindex => $cat)
					{
						if ($catindex > 0)
							$replacement .= '$1';
						$replacement .= '<a href="' .$cat['link']  . '" target="$2">' . $cat['name'] . '</a>';
					}
					$skin_template = preg_replace('/__CATEGORYNAMELINK\[(.*)\]\{(.*)\}__/', $replacement, $skin_template);
				}
			}

			if ( isset($slide->tags) )
			{
				foreach($slide->tags as $tagindex => $tag)
				{
					if ($tagindex == 0)
					{
						$skin_template = str_replace('__TAGID__',  $tag['id'], $skin_template);
						$skin_template = str_replace('__TAGNAME__',  $tag['name'], $skin_template);
						$skin_template = str_replace('__TAGSLUG__',  $tag['slug'], $skin_template);
						$skin_template = str_replace('__TAGLINK__',  $tag['link'], $skin_template);
					}

					$skin_template = str_replace('__TAGID' . $tagindex . '__',  $tag['id'], $skin_template);
					$skin_template = str_replace('__TAGNAME' . $tagindex . '__',  $tag['name'], $skin_template);
					$skin_template = str_replace('__TAGSLUG' . $tagindex . '__',  $tag['slug'], $skin_template);
					$skin_template = str_replace('__TAGLINK' . $tagindex . '__',  $tag['link'], $skin_template);
				}

				$skin_template = preg_replace('/__TAGNAME\[(.*)\]__/', implode('$1', $this->get_array_column($slide->tags, 'name')), $skin_template);

				if ( preg_match('/__TAGNAMELINK\[(.*)\]\{(.*)\}__/', $skin_template) )
				{
					$replacement = '';
					foreach($slide->tags as $tagindex => $tag)
					{
						if ($tagindex > 0)
							$replacement .= '$1';
						$replacement .= '<a href="' .$tag['link']  . '" target="$2">' . $tag['name'] . '</a>';
					}
					$skin_template = preg_replace('/__TAGNAMELINK\[(.*)\]\{(.*)\}__/', $replacement, $skin_template);
				}
			}

			$ret .= $skin_template;
			$ret .= '</div>';
		}

		if ($count > 0)
			$ret .= '</li>';

		return $ret;
	}

	function get_page_object($options, $post)
	{
		if (is_object($post))
			$post = get_object_vars($post);

		$thumbnail = '';
		$image = '';
		if ( has_post_thumbnail($post['ID']) )
		{
			$featured_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), $options->featuredimagesize);
			$thumbnail = $featured_thumb[0];

			$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post['ID']), 'full');
			$image = $featured_image[0];
		}

		$excerpt = $post['post_excerpt'];
		if (empty($excerpt))
		{
			$excerpts = explode( '<!--more-->', $post['post_content'] );
			$excerpt = $excerpts[0];
			$excerpt = strip_tags( str_replace(']]>', ']]&gt;', strip_shortcodes($excerpt)) );
		}
		$excerpt = wonderplugin_carousel_wp_trim_words($excerpt, $options->excerptlength);

		$post_item = array(
				'type'			=> 0,
				'image'			=> $image,
				'thumbnail'		=> $thumbnail,
				'title'			=> $post['post_title'],
				'posttitle'		=> $post['post_title'],
				'description'	=> $excerpt,
				'weblink'		=> get_permalink($post['ID']),
				'linktarget'	=> $options->postlinktarget,
				'datetime'		=> $post['post_date'],
				'date'			=> date('Y-m-d', strtotime($post['post_date']))
		);

		if (isset($options->postlightbox))
		{
			$post_item['lightbox'] = $options->postlightbox;
			$post_item['lightboxsize'] = $options->postlightboxsize;
			$post_item['lightboxwidth'] = $options->postlightboxwidth;
			$post_item['lightboxheight'] = $options->postlightboxheight;

			if (isset($options->posttitlelink) && strtolower($options->posttitlelink) === 'true')
			{
				$post_item['posttitle'] = '<a class="amazingcarousel-posttitle-link" href="' . $post_item['weblink'] . '"';
				if (isset($post_item['linktarget']) && strlen($post_item['linktarget']) > 0)
					$post_item['posttitle'] .= ' target="' . $post_item['linktarget'] . '"';
				$post_item['posttitle'] .= '>' . $post['post_title'] . '</a>';
			}
		}

		return (object) $post_item;
	}

	function get_page_item($options) {

		$post = get_post($options->pageid);

		$items = array();

		if ($options->pagechildmode >= 1 && $options->pagechildmode <= 3)
		{
			$items[] = $this->get_page_object($options, $post);
		}

		if ($options->pagechildmode >= 2)
		{
			$args = array(
						'post_type'   	=> 'page',
						'numberposts' 	=> -1,
						'sort_order'	=> $options->pageorder,
						'sort_column' 	=> $options->pageorderby,
						'post_status' 	=> 'publish'
					);

			if ($options->pagechildmode == 2 || $options->pagechildmode == 4)
			{
				$args['parent'] = $options->pageid;
			}
			else if ($options->pagechildmode == 3 || $options->pagechildmode == 5)
			{
				$args['child_of'] = $options->pageid;
			}

			$posts = get_pages($args);

			foreach($posts as $post)
			{
				$items[] = $this->get_page_object($options, $post);
			}
		}

		return $items;
	}

	function create_page_code($slides, $data, $id) {

		$ret = '';

		$count = 0;

		foreach($slides as $slide)
		{
			if ($count == 0)
				$ret .= '<li class="amazingcarousel-item">';
			else if ($count % $data->rownumber == 0)
				$ret .= '</li><li class="amazingcarousel-item">';

			$count++;

			$ret .= '<div class="amazingcarousel-item-container">';

			$skin_template = str_replace('&amp;',  '&', $data->skintemplate);
			$skin_template = str_replace('&lt;',  '<', $skin_template);
			$skin_template = str_replace('&gt;',  '>', $skin_template);

			$image_code = '';

			if ($slide->thumbnail && strlen($slide->thumbnail) > 0)
			{
				if ( isset($slide->lightbox) && strtolower($slide->lightbox) === 'true' )
				{
					$image_code .= '<a';
					if (!empty($data->aextraprops))
						$image_code .= ' ' . $data->aextraprops;
					$image_code .= ' href="';
					$image_code .= $slide->image;

					if ($slide->title && strlen($slide->title) > 0)
						$image_code .= '" data-title="' . $this->eacape_html_quotes($slide->title);

					if ($slide->description && strlen($slide->description) > 0)
						$image_code .= '" data-description="' . $this->eacape_html_quotes($slide->description);

					if ( isset($slide->lightboxsize) && strtolower($slide->lightboxsize) === 'true' )
						$image_code .= '" data-width="' .  $slide->lightboxwidth . '" data-height="' .  $slide->lightboxheight;

					$image_code .= '" data-thumbnail="' . $slide->thumbnail;

					$image_code .= '" class="wondercarousellightbox wondercarousellightbox-' . $id . '"';
					if ( !isset($data->lightboxnogroup) || strtolower($data->lightboxnogroup) !== 'true' )
						$image_code .= ' data-group="wondercarousellightbox-' . $id . '"';

					$image_code .= '>';
				}
				else if ($slide->weblink && strlen($slide->weblink) > 0)
				{
					$image_code .= '<a';
					if (!empty($data->aextraprops))
						$image_code .= ' ' . $data->aextraprops;
					$image_code .= ' href="' . $slide->weblink . '"';
					if ($slide->linktarget && strlen($slide->linktarget) > 0)
						$image_code .= ' target="' . $slide->linktarget . '"';
					$image_code .= '>';
				}

				$image_code .= '<img class="amazingcarousel-image-img"';

				if (!empty($data->imgextraprops))
					$image_code .= ' ' . $data->imgextraprops;

				if ((isset($data->deferloading) && (strtolower($data->deferloading) === 'true')) || (isset($data->enablelazyload) && (strtolower($data->enablelazyload) === 'true')))
				{	
					if (!isset($data->usebase64) || strtolower($data->usebase64) === 'true')
						$image_code .= ' src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-aclazysrc="' . $slide->thumbnail . '"';
					else
						$image_code .= ' src="" data-aclazysrc="' . $slide->thumbnail . '"';
				}
				else
				{	
					$image_code .= ' src="' . $slide->thumbnail . '"';
				}

				$image_code .= ' alt="' . $this->eacape_html_quotes(strip_tags($slide->title)) . '"';
				$image_code .= ' data-description="' . $this->eacape_html_quotes($slide->description) . '"';
				$image_code .= ' />';

				if ((isset($slide->lightbox) && strtolower($slide->lightbox) === 'true') || ($slide->weblink && strlen($slide->weblink) > 0))
				{
					$image_code .= '</a>';
				}
			}

			$skin_template = str_replace('__ID__',  $count, $skin_template);
			$skin_template = str_replace('__IMAGE__',  $image_code, $skin_template);
			$skin_template = str_replace('__TITLE__',  $slide->posttitle, $skin_template);
			$skin_template = str_replace('__DESCRIPTION__',  $slide->description, $skin_template);
			$skin_template = str_replace('__HREF__',  $slide->weblink, $skin_template);
			$skin_template = str_replace('__TARGET__',  $slide->linktarget, $skin_template);
			$skin_template = str_replace('__DATETIME__',  $slide->datetime, $skin_template);
			$skin_template = str_replace('__DATE__',  $slide->date, $skin_template);
			$skin_template = str_replace('__BUTTON__',  '', $skin_template);
			$skin_template = str_replace('__SOCIALMEDIA__',  '', $skin_template);
			
			$ret .= $skin_template;
			$ret .= '</div>';
		}

		if ($count > 0)
			$ret .= '</li>';

		return $ret;
	}

	function delete_item($id) {

		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$ret = $wpdb->query( $wpdb->prepare(
				"
				DELETE FROM $table_name WHERE id=%s
				",
				$id
		) );

		return $ret;
	}

	function trash_item($id) {

		return $this->set_item_status($id, 0);
	}

	function restore_item($id) {

		return $this->set_item_status($id, 1);
	}

	function set_item_status($id, $status) {

		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$ret = false;
		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$data = json_decode($item_row->data, true);
			$data['publish_status'] = $status;
			$data = json_encode($data);

			$update_ret = $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET data=%s WHERE id=%d", $data, $id ) );
			if ( $update_ret )
				$ret = true;
		}

		return $ret;
	}

	function clone_item($id) {

		global $wpdb, $user_ID;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$cloned_id = -1;

		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$time = current_time('mysql');
			$authorid = $user_ID;

			$ret = $wpdb->query( $wpdb->prepare(
					"
					INSERT INTO $table_name (name, data, time, authorid)
					VALUES (%s, %s, %s, %s)
					",
					$item_row->name . " Copy",
					$item_row->data,
					$time,
					$authorid
			) );

			if ($ret)
				$cloned_id = $wpdb->insert_id;
		}

		return $cloned_id;
	}

	function is_db_table_exists() {

		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		return ( strtolower($wpdb->get_var("SHOW TABLES LIKE '$table_name'")) == strtolower($table_name) );
	}

	function is_id_exist($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$carousel_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		return ($carousel_row != null);
	}

	function create_db_table() {

		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$charset = '';
		if ( !empty($wpdb -> charset) )
			$charset = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( !empty($wpdb -> collate) )
			$charset .= " COLLATE $wpdb->collate";

		$sql = "CREATE TABLE $table_name (
		id INT(11) NOT NULL AUTO_INCREMENT,
		name tinytext DEFAULT '' NOT NULL,
		data MEDIUMTEXT DEFAULT '' NOT NULL,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		authorid tinytext NOT NULL,
		PRIMARY KEY  (id)
		) $charset;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	function save_item($item) {

		global $wpdb, $user_ID;

		if ( !$this->is_db_table_exists() )
		{
			$this->create_db_table();

			$create_error = "CREATE DB TABLE - ". $wpdb->last_error;
			if ( !$this->is_db_table_exists() )
			{
				return array(
						"success" => false,
						"id" => -1,
						"message" => $create_error
				);
			}
		}

		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$id = $item["id"];
		$name = $item["name"];

		unset($item["id"]);
		$data = json_encode($item);

		if ( empty($data) )
		{
			$json_error = "json_encode error";
			if ( function_exists('json_last_error_msg') )
				$json_error .= ' - ' . json_last_error_msg();
			else if ( function_exists('json_last_error') )
				$json_error .= 'code - ' . json_last_error();

			return array(
					"success" => false,
					"id" => -1,
					"message" => $json_error
			);
		}

		$time = current_time('mysql');
		$authorid = $user_ID;

		if ( ($id > 0) && $this->is_id_exist($id) )
		{
			$ret = $wpdb->query( $wpdb->prepare(
					"
					UPDATE $table_name
					SET name=%s, data=%s, time=%s, authorid=%s
					WHERE id=%d
					",
					$name,
					$data,
					$time,
					$authorid,
					$id
			) );

			if (!$ret)
			{
				return array(
						"success" => false,
						"id" => $id,
						"message" => "UPDATE - ". $wpdb->last_error
					);
			}
		}
		else
		{
			$ret = $wpdb->query( $wpdb->prepare(
					"
					INSERT INTO $table_name (name, data, time, authorid)
					VALUES (%s, %s, %s, %s)
					",
					$name,
					$data,
					$time,
					$authorid
			) );

			if (!$ret)
			{
				return array(
						"success" => false,
						"id" => -1,
						"message" => "INSERT - " . $wpdb->last_error
				);
			}

			$id = $wpdb->insert_id;
		}

		return array(
				"success" => true,
				"id" => intval($id),
				"message" => "Carousel published!"
		);
	}

	function get_list_data() {

		if ( !$this->is_db_table_exists() )
			$this->create_db_table();

		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$rows = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A);

		$ret = array();

		if ( $rows )
		{
			foreach ( $rows as $row )
			{
				$ret[] = array(
							"id" => $row['id'],
							'name' => $row['name'],
							'data' => $row['data'],
							'time' => $row['time'],
							'authorid' => $row['authorid']
						);
			}
		}

		return $ret;
	}

	function get_item_data($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . "wonderplugin_carousel";

		$ret = "";
		$item_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id) );
		if ($item_row != null)
		{
			$ret = $item_row->data;
		}

		return $ret;
	}


	function get_settings() {

		$userrole = get_option( 'wonderplugin_carousel_userrole' );
		if ( $userrole == false )
		{
			update_option( 'wonderplugin_carousel_userrole', 'manage_options' );
			$userrole = 'manage_options';
		}

		$thumbnailsize = get_option( 'wonderplugin_carousel_thumbnailsize' );
		if ( $thumbnailsize == false )
		{
			update_option( 'wonderplugin_carousel_thumbnailsize', 'large' );
			$thumbnailsize = 'large';
		}

		$keepdata = get_option( 'wonderplugin_carousel_keepdata', 1 );

		$disableupdate = get_option( 'wonderplugin_carousel_disableupdate', 0 );

		$supportwidget = get_option( 'wonderplugin_carousel_supportwidget', 1 );

		$addjstofooter = get_option( 'wonderplugin_carousel_addjstofooter', 0 );

		$jsonstripcslash = get_option( 'wonderplugin_carousel_jsonstripcslash', 1 );

		$sanitizehtmlcontent = get_option( 'wonderplugin_carousel_sanitizehtmlcontent', 1 );

		$doublebackslash = get_option( 'wonderplugin_carousel_doublebackslash', 0 );

		$jetpackdisablelazyload = get_option( 'wonderplugin_carousel_jetpackdisablelazyload', 1 );

		$supportmultilingual = get_option( 'wonderplugin_carousel_supportmultilingual', 1 );

		$settings = array(
			"userrole" => $userrole,
			"thumbnailsize" => $thumbnailsize,
			"keepdata" => $keepdata,
			"disableupdate" => $disableupdate,
			"supportwidget" => $supportwidget,
			"addjstofooter" => $addjstofooter,
			"jsonstripcslash" => $jsonstripcslash,
			"sanitizehtmlcontent" => $sanitizehtmlcontent,
			"doublebackslash" => $doublebackslash,
			"jetpackdisablelazyload" => $jetpackdisablelazyload,
			"supportmultilingual" => $supportmultilingual
		);

		return $settings;

	}

	function save_settings($options) {

		if (!isset($options) || !isset($options['userrole']))
			$userrole = 'manage_options';
		else if ( $options['userrole'] == "Editor")
			$userrole = 'moderate_comments';
		else if ( $options['userrole'] == "Author")
			$userrole = 'upload_files';
		else
			$userrole = 'manage_options';
		update_option( 'wonderplugin_carousel_userrole', $userrole );

		if (isset($options) && isset($options['thumbnailsize']))
			$thumbnailsize = $options['thumbnailsize'];
		else
			$thumbnailsize = 'large';
		update_option( 'wonderplugin_carousel_thumbnailsize', $thumbnailsize );

		if (!isset($options) || !isset($options['keepdata']))
			$keepdata = 0;
		else
			$keepdata = 1;
		update_option( 'wonderplugin_carousel_keepdata', $keepdata );

		if (!isset($options) || !isset($options['disableupdate']))
			$disableupdate = 0;
		else
			$disableupdate = 1;
		update_option( 'wonderplugin_carousel_disableupdate', $disableupdate );

		if (!isset($options) || !isset($options['supportwidget']))
			$supportwidget = 0;
		else
			$supportwidget = 1;
		update_option( 'wonderplugin_carousel_supportwidget', $supportwidget );

		if (!isset($options) || !isset($options['addjstofooter']))
			$addjstofooter = 0;
		else
			$addjstofooter = 1;
		update_option( 'wonderplugin_carousel_addjstofooter', $addjstofooter );

		if (!isset($options) || !isset($options['jsonstripcslash']))
			$jsonstripcslash = 0;
		else
			$jsonstripcslash = 1;
		update_option( 'wonderplugin_carousel_jsonstripcslash', $jsonstripcslash );

		if (!isset($options) || !isset($options['doublebackslash']))
			$doublebackslash = 0;
		else
			$doublebackslash = 1;
		update_option( 'wonderplugin_carousel_doublebackslash', $doublebackslash );

		if (!isset($options) || !isset($options['sanitizehtmlcontent']))
			$sanitizehtmlcontent = 0;
		else
			$sanitizehtmlcontent = 1;
		update_option( 'wonderplugin_carousel_sanitizehtmlcontent', $sanitizehtmlcontent );

		if (!isset($options) || !isset($options['jetpackdisablelazyload']))
			$jetpackdisablelazyload = 0;
		else
			$jetpackdisablelazyload = 1;
		update_option( 'wonderplugin_carousel_jetpackdisablelazyload', $jetpackdisablelazyload );

		if (!isset($options) || !isset($options['supportmultilingual']))
			$supportmultilingual = 0;
		else
			$supportmultilingual = 1;
		update_option( 'wonderplugin_carousel_supportmultilingual', $supportmultilingual );
	}

	function get_plugin_info() {

		$info = get_option('wonderplugin_carousel_information');
		if ($info === false)
			return false;

		return unserialize($info);
	}

	function save_plugin_info($info) {

		update_option( 'wonderplugin_carousel_information', serialize($info) );
	}

	function check_license($options) {

		$ret = array(
				"status" => "empty"
		);

		if ( !isset($options) || empty($options['wonderplugin-carousel-key']) )
		{
			return $ret;
		}

		$key = sanitize_text_field( $options['wonderplugin-carousel-key'] );
		if ( empty($key) )
			return $ret;

		$update_data = $this->controller->get_update_data('register', $key);
		if( $update_data === false )
		{
			$ret['status'] = 'timeout';
			return $ret;
		}

		if ( isset($update_data->key_status) )
			$ret['status'] = $update_data->key_status;

		return $ret;
	}

	function deregister_license($options) {

		$ret = array(
				"status" => "empty"
		);

		if ( !isset($options) || empty($options['wonderplugin-carousel-key']) )
			return $ret;

		$key = sanitize_text_field( $options['wonderplugin-carousel-key'] );
		if ( empty($key) )
			return $ret;

		$info = $this->get_plugin_info();
		$info->key = '';
		$info->key_status = 'empty';
		$info->key_expire = 0;
		$this->save_plugin_info($info);

		$update_data = $this->controller->get_update_data('deregister', $key);
		if ($update_data === false)
		{
			$ret['status'] = 'timeout';
			return $ret;
		}

		$ret['status'] = 'success';

		return $ret;
	}
}
