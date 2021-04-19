<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class AdminDonorController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "donor_nama";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = false;
		$this->button_action_style = "button_dropdown";
		$this->button_add = true;
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = true;
		$this->table = "ref_donor";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Donor Id","name"=>"donor_id"];
			$this->col[] = ["label"=>"Donor Noktp","name"=>"donor_noktp"];
			$this->col[] = ["label"=>"Donor Nama","name"=>"donor_nama"];
			$this->col[] = ["label"=>"Donor Jeniskelamin","name"=>"donor_jeniskelamin","join"=>"jeniskelamin,nama"];
			$this->col[] = ["label"=>"Donor Status","name"=>"donor_status"];
			$this->col[] = ["label"=>"Donor Alamatrumah","name"=>"donor_alamatrumah"];
			$this->col[] = ["label"=>"Donor Nohp","name"=>"donor_nohp"];
			$this->col[] = ["label"=>"Donor Pekerjaan","name"=>"donor_pekerjaan","join"=>"pekerjaan,pekerjaan_nama"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'No Donor', 'name' => 'donor_id', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'No KTP/SIM/Paspor', 'name' => 'donor_noktp', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10', 'placeholder' => 'Mohon ditulis dengan format No KTP/SIM/Paspor Jika tidak ada tulis - contoh : No KTP/SIM/-', 'value' => 'string'];
		$this->form[] = ['label' => 'Nama Lengkap', 'name' => 'donor_nama', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Jenis Kelamin', 'name' => 'donor_jeniskelamin', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'jeniskelamin,nama'];
		$this->form[] = ['label' => 'Status', 'name' => 'donor_status', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Nikah;Belum Nikah'];
		$this->form[] = ['label' => 'Alamat Rumah', 'name' => 'donor_alamatrumah', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'No HP', 'name' => 'donor_nohp', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Wilayah', 'name' => 'donor_wilayah', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'wilayah,wilayah_nama'];
		$this->form[] = ['label' => 'Kecamatan', 'name' => 'donor_kecamatan', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'kecamatan,kecamatan_nama'];
		$this->form[] = ['label' => 'Kelurahan/Desa', 'name' => 'donor_kelurahan', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'desa,desa_nama'];
		$this->form[] = ['label' => 'Alamat Kantor', 'name' => 'donor_alamatkantor', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Pekerjaan', 'name' => 'donor_pekerjaan', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'pekerjaan,pekerjaan_nama'];
		$this->form[] = ['label' => 'Tempat Kelahiran', 'name' => 'donor_tempatkelahiran', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Tanggallahir', 'name' => 'donor_tanggallahir', 'type' => 'date', 'validation' => 'required', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Apharesis', 'name' => 'donor_apharesis', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Ya;Tidak'];
		$this->form[] = ['label' => 'Penghargaan', 'name' => 'donor_penghargaan', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Belum Ada Penghargaan;25 kali;50 kali;75 kali;100 kali'];
		$this->form[] = ['label' => 'Puasa', 'name' => 'donor_puasa', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Ya;Tidak'];
		$this->form[] = ['label' => 'Mau Donor saat dibutuhkan?', 'name' => 'donor_butuh', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Ya;Tidak'];
		$this->form[] = ['label' => 'Donor Terakhir', 'name' => 'donor_terakhir', 'type' => 'date', 'validation' => 'required', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Donor Ke', 'name' => 'donor_ke', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Nama Dokter', 'name' => 'donor_namadokter', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'dokter,dokter_nama'];
		$this->form[] = ['label' => 'Riwayat Medis', 'name' => 'donor_riwayatmedis', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Diambil Sebanyak', 'name' => 'donor_diambil', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '350;450'];
		$this->form[] = ['label' => 'Kantong', 'name' => 'donor_kantong', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'S;D;T;Q;P'];
		$this->form[] = ['label' => 'Tensi', 'name' => 'donor_tensi', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Nadi', 'name' => 'donor_nadi', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Berat Badan', 'name' => 'donor_bb', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Tinggi Badan', 'name' => 'donor_tb', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Suhu', 'name' => 'donor_suhu', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Petugas Administrasi', 'name' => 'donor_petugasadministrasi', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'petugasadministrasi,petugasadministrasi_nama'];
		$this->form[] = ['label' => 'Validasi', 'name' => 'donor_validasi', 'type' => 'checkbox', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Kartu Donor;KTP;SIM;Paspor'];
		$this->form[] = ['label' => 'Petugas Hemoglobin', 'name' => 'donor_petugashb', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'petugashb,petugashb_nama'];
		$this->form[] = ['label' => 'Macam Donor', 'name' => 'donor_macamdonor', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Sukarela;Pengganti'];
		$this->form[] = ['label' => 'Metode', 'name' => 'donor_metode', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'Biasa;Apharesis;Autologus'];
		$this->form[] = ['label' => 'Hemoglobin', 'name' => 'donor_hb', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Golongan Darah', 'name' => 'donor_goldar', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'A+;A-;AB+;AB-;O+;O-;B+;B-'];
		$this->form[] = ['label' => 'Petugas Aftap', 'name' => 'donor_petugasaftap', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'petugasaftap,petugasaftap_nama'];
		$this->form[] = ['label' => 'Kode Timbangan', 'name' => 'donor_kodetimbangan', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Penusukan Ulang', 'name' => 'donor_penusukanulang', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => 'tanpa penusukan ulang;1 kali;2 kali'];
		$this->form[] = ['label' => 'Lama Pengambilan', 'name' => 'donor_lamapengambilan', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '>=12 menit;12-15 menit;>15 menit'];
		$this->form[] = ['label' => 'No Kantong', 'name' => 'donor_nokantong', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Tanggal Donor', 'name' => 'donor_tanggaldonor', 'type' => 'date', 'validation' => 'required', 'width' => 'col-sm-10'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ['label'=>'No Donor','name'=>'donor_id','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'No KTP/SIM/Paspor','name'=>'donor_noktp','type'=>'text','validation'=>'required','width'=>'col-sm-10','placeholder'=>'Mohon ditulis dengan format No KTP/SIM/Paspor Jika tidak ada tulis - contoh : No KTP/SIM/-'];
		//$this->form[] = ['label'=>'Nama Lengkap','name'=>'donor_nama','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Jenis Kelamin','name'=>'donor_jeniskelamin','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'jeniskelamin,nama'];
		//$this->form[] = ['label'=>'Status','name'=>'donor_status','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Nikah;Belum Nikah'];
		//$this->form[] = ['label'=>'Alamat Rumah','name'=>'donor_alamatrumah','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'No HP','name'=>'donor_nohp','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Wilayah','name'=>'donor_wilayah','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'wilayah,wilayah_nama'];
		//$this->form[] = ['label'=>'Kecamatan','name'=>'donor_kecamatan','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'kecamatan,kecamatan_nama'];
		//$this->form[] = ['label'=>'Kelurahan/Desa','name'=>'donor_kelurahan','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'desa,desa_nama'];
		//$this->form[] = ['label'=>'Alamat Kantor','name'=>'donor_alamatkantor','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Pekerjaan','name'=>'donor_pekerjaan','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'pekerjaan,pekerjaan_nama'];
		//$this->form[] = ['label'=>'Tempat Kelahiran','name'=>'donor_tempatkelahiran','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Tanggallahir','name'=>'donor_tanggallahir','type'=>'date','validation'=>'required','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Apharesis','name'=>'donor_apharesis','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Ya;Tidak'];
		//$this->form[] = ['label'=>'Penghargaan','name'=>'donor_penghargaan','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Belum Ada Penghargaan;25 kali;50 kali;75 kali;100 kali'];
		//$this->form[] = ['label'=>'Puasa','name'=>'donor_puasa','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Ya;Tidak'];
		//$this->form[] = ['label'=>'Mau Donor saat dibutuhkan?','name'=>'donor_butuh','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Ya;Tidak'];
		//$this->form[] = ['label'=>'Donor Terakhir','name'=>'donor_terakhir','type'=>'date','validation'=>'required','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Donor Ke','name'=>'donor_ke','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Nama Dokter','name'=>'donor_namadokter','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'dokter,dokter_nama'];
		//$this->form[] = ['label'=>'Riwayat Medis','name'=>'donor_riwayatmedis','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Diambil Sebanyak','name'=>'donor_diambil','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'350;450'];
		//$this->form[] = ['label'=>'Kantong','name'=>'donor_kantong','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'S;D;T;Q;P'];
		//$this->form[] = ['label'=>'Tensi','name'=>'donor_tensi','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Nadi','name'=>'donor_nadi','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Berat Badan','name'=>'donor_bb','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Tinggi Badan','name'=>'donor_tb','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Suhu','name'=>'donor_suhu','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Petugas Administrasi','name'=>'donor_petugasadministrasi','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'petugasadministrasi,petugasadministrasi_nama'];
		//$this->form[] = ['label'=>'Validasi','name'=>'donor_validasi','type'=>'checkbox','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Kartu Donor;KTP;SIM;Paspor'];
		//$this->form[] = ['label'=>'Petugas Hemoglobin','name'=>'donor_petugashb','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'petugashb,petugashb_nama'];
		//$this->form[] = ['label'=>'Macam Donor','name'=>'donor_macamdonor','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Sukarela;Pengganti'];
		//$this->form[] = ['label'=>'Metode','name'=>'donor_metode','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'Biasa;Apharesis;Autologus'];
		//$this->form[] = ['label'=>'Hemoglobin','name'=>'donor_hb','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Golongan Darah','name'=>'donor_goldar','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'A+;A-;AB+;AB-;O+;O-;B+;B-'];
		//$this->form[] = ['label'=>'Petugas Aftap','name'=>'donor_petugasaftap','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'petugasaftap,petugasaftap_nama'];
		//$this->form[] = ['label'=>'Kode Timbangan','name'=>'donor_kodetimbangan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Penusukan Ulang','name'=>'donor_penusukanulang','type'=>'select2','validation'=>'required','width'=>'col-sm-10','dataenum'=>'tanpa penusukan ulang;1 kali;2 kali'];
		//$this->form[] = ['label'=>'Lama Pengambilan','name'=>'donor_lamapengambilan','type'=>'radio','validation'=>'required','width'=>'col-sm-10','dataenum'=>'>=12 menit;12-15 menit;>15 menit'];
		//$this->form[] = ['label'=>'No Kantong','name'=>'donor_nokantong','type'=>'text','validation'=>'required','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Tanggal Donor','name'=>'donor_tanggaldonor','type'=>'date','validation'=>'required','width'=>'col-sm-10'];
		# OLD END FORM

		/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
		$this->sub_module = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
		$this->addaction = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
		$this->button_selected = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
		$this->alert        = array();



		/* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
		$this->index_button = array();



		/* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
		$this->table_row_color = array();


		/*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
		$this->index_statistic = array();



		/*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
		$this->script_js = NULL;


		/*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
		$this->pre_index_html = null;



		/*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
		$this->post_index_html = null;



		/*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
		$this->load_js = array();



		/*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
		$this->style_css = "<style> .str{ mso-number-format:\@; } </style>";



		/*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
		$this->load_css = array();
	}


	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	public function actionButtonSelected($id_selected, $button_name)
	{
		//Your code here

	}


	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	public function hook_query_index(&$query)
	{
		//Your code here

	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */
	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	public function hook_before_add(&$postdata)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	public function hook_after_add($id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	public function hook_before_edit(&$postdata, $id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_edit($id)
	{
		//Your code here 

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_before_delete($id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_delete($id)
	{
		//Your code here

	}



	//By the way, you can still create your own method in here... :) 


}