<?php
class Photoalbum extends db{

	public $db = null;
	private $array = array();
	public $result = array();
	
	function __construct($db)
	{
		$this->db = &$db;
		//parent::__construct();
	}
	
	function pregReplace($content,$base_path,$photos_folder,$photos_per_page_up){

			if (preg_match_all('/{photoalbum\sid="\d{1,2}"}/',$content,$matches))
				if (is_array($matches))
					foreach ($matches as $key=>$val)
						foreach ($matches[$key] as $key2=>$val2)
							if (preg_match("/\d{1,2}/", $matches[$key][$key2], $submathes)){
								$photoalbum_id = intval($submathes[0]);
								$out_photoalbum = $this->show_photoalbum(array("id"=>$photoalbum_id),$base_path,$photos_folder,$photos_per_page_up);
								if (strlen(trim($out_photoalbum))>0)
									$content = str_replace($matches[$key][$key2],$out_photoalbum,$content);
							}
				
			return $content;
	}
	
	function show_photoalbum ($params,$base_path,$photos_folder,$photos_per_page_sup) {

		global $db;
		global $smarty;
		$res = $db->get_single("SELECT url FROM fw_tree WHERE module='photoalbum' LIMIT 1");
		$support_url=$res['url'];
		
		$album_id=$params['id'];
		
		$photos_list=$db->get_all("SELECT *,(SELECT COUNT(*) FROM fw_photoalbum_images WHERE parent='$album_id') AS count FROM fw_photoalbum_images WHERE parent='$album_id' ORDER BY sort_order LIMIT ".$photos_per_page_sup);
		
		for ($i=0;$i<sizeof($photos_list);$i++) {
			$photo_file=$base_path.'/'.$photos_folder.'/'.$photos_list[$i]['id'].'.'.$photos_list[$i]['ext'];
			$output=Image::image_details($photo_file);
			$photos_list[$i]['width']=$output['width']+20;
			$photos_list[$i]['height']=$output['height']+20;
		}
		
		if ($photos_list[0]['count']>$photos_per_page_sup) {
			$cl=$db->get_all("SELECT *,(SELECT parent FROM fw_photoalbums WHERE id='$album_id') AS album FROM fw_photoalbum_cat c WHERE c.status='1' ORDER BY c.param_left");
			$album_parent=$cl[0]['album'];
			$cl=Common::get_nodes_list($cl);
			
			foreach ($cl as $k=>$v) {
				if ($v['id']==$album_parent) $album_url=$v['full_url'];
			}
			
			$album_url=$support_url.$album_url.'album_'.$album_id;

			$smarty->assign("album_url",$album_url);
		}
		
		$smarty->assign("photos_list",$photos_list);
		$smarty->assign("base_path",$base_path);
		$smarty->assign("photos_folder",$photos_folder);
		$smarty->assign("photos_per_page_sup",$photos_per_page_sup);
		$smarty->assign("total_photos",$photos_list[0]['count']);
		
		$output=$smarty->fetch($base_path.'/modules/photoalbum/front/templates/show_photoalbum_support.html');
		
		return $output;
		
	}


	function getAlbumIdByCategory($cat_id)
	{
		$this->result = $this->db->get_all("select fw_photo_categories.photoalbum_id 
		from fw_photo_categories
		left join fw_photoalbums on fw_photo_categories.photoalbum_id = fw_photoalbums.id 
		where fw_photoalbums.album_type = 'photo' and 
		fw_photo_categories.cat_id = '".intval($cat_id)."' and fw_photoalbums.status = '1'");
		if ($this->result && count($this->result) > 0)
		{
			foreach ($this->result as $row)
			{
				$this->array[] = $row['photoalbum_id'];
			}
			return $this->array;
		}
		else
			return null;
	}

	function getAlbumByCategory($cat_id)
	{
		$this->result = $this->db->get_single("select fw_photoalbums.*, fw_photoalbum_cat.url 
		from fw_photo_categories
		left join fw_photoalbums on fw_photo_categories.photoalbum_id = fw_photoalbums.id
		left join fw_photoalbum_cat on fw_photoalbums.parent = fw_photoalbum_cat.id 
		where fw_photoalbums.album_type = 'photo' and 
		fw_photo_categories.cat_id = '".intval($cat_id)."' and fw_photoalbums.status = '1' limit 1");
		if ($this->result && count($this->result) > 0)
		{
			return $this->result;
		}
		else
			return null;
	}
	
	function get_photos_by_album($album_id, $hit = false)
	{
		if ($hit)
			$hit = " and hit = '1' ";

		$this->result = $this->db->get_single("select * from fw_photoalbum_images where parent = '{$album_id}' " . $hit);

		//если нет отмеченных хит то вытаскиваем первую
		if (count($this->result) && $hit)
			$this->result = $this->db->get_single("select * from fw_photoalbum_images where parent = '{$album_id}' order by sort_order asc limit 1 ");
		
		return $this->result;
		
	}
	

	function get_video_by_gallery($album_id, $hit = false)
	{
		if ($hit)
			$hit = " and hit = '1' ";

		$this->result = $this->db->get_single("select * from fw_photoalbum_images where parent = '{$album_id}' " . $hit);
		return $this->result;
		
	}
	
	/**
	 * 
	 * Находим фотки по категории (ресторану)
	 * @param int $cat_id
	 * @author andrey.s
	 */
	function getPhotosByCategory($cat_id, $limit = null, $hit = null)
	{
		if (!empty($limit))
		{
			$limit = " limit " . intval($limit);
		}
		
		if ($hit)
		{
			$hit = " and hit = '1' ";
		}
		

		$album = $this->getAlbumIdByCategory($cat_id);
		
		if (empty($album))
			return false;
		
		$this->result = $this->db->get_all("
			select * from 
			fw_photoalbum_images 
			where parent in (".implode(",", $album).")" . $hit . $limit);
					

		if ($this->result && count($this->result) > 0)
		{
			return $this->result;
		}
		else
		{
			return null;
		}
		
	}
	
	/**
	 * Находим все альбомы
	 */
	function getPhotoalbums()
	{
		$this->result = $this->db->get_all("select fw_photoalbums.*, fw_photoalbum_cat.url from
		fw_photoalbums 
		left join fw_photoalbum_cat on fw_photoalbums.parent = fw_photoalbum_cat.id
		where fw_photoalbums.status = '1' and fw_photoalbum_cat.status = '1' and fw_photoalbums.album_type = 'photo' ");
		if ($this->result)
			return $this->result;
		else
			return null;
	}
	
	/**
	 * Находим все видеогалереи
	 */
	function getVideoGalleries()
	{
		$this->result = $this->db->get_all("select fw_photoalbums.*, fw_photoalbum_cat.url from
		fw_photoalbums 
		left join fw_photoalbum_cat on fw_photoalbums.parent = fw_photoalbum_cat.id
		where fw_photoalbums.status = '1' and fw_photoalbum_cat.status = '1' and fw_photoalbums.album_type = 'video' ");
		if ($this->result)
			return $this->result;
		else
			return null;
	}
	
}

?>