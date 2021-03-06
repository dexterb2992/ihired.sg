<?php
require APPPATH."controllers/Base_Controller.php";

class Company extends Base_Controller {

	public function __construct(){
	
		parent::__construct();

		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;
		
		$this->load->model('admin/Company_model', 'company', true);
		$this->load->model('admin/Industry_model', 'industry', true);
	}

	public function index(){
		$data = array();
		$data['headers']	= $this;
		$data['js_module'] = $this->class;
		$companies = array();
		$industries = array();

		$companies = $this->company->all('array');
		$industries = $this->industry->all('array');

		$data['companies'] = $companies;
		$data['industries'] = $industries;
		$data['_industries'] = array();

		foreach ($data['industries'] as $industry) {
			$data['_industries'][] = array(
				'label' => $industry['industry_name'],
				'value' => $industry['industry_id']
			);
		}

		$this->load->view('desktop/admin/company', $data);
	}

	public function create(){
		$company_name = $this->input->post('company_name');
		$industry_name = $this->input->post('industry_name');
		$industry_id = $this->input->post('industry_id');

		if( $industry_id == 0 ){
			$industry = array(
				"industry_name" => $industry_name,
				"user_id" => $this->session->userdata('user_id'),
				"date_added" => date('Y-m-d')
			);
			$res = $this->industry->create($industry);
			if( $res !== false ){
				$industry_id = $res;
			}else{
				echo json_encode( array(
					'success' => false, 
					'msg' => 'Unable to create an Industry right now. Please try again later.'
					) 
				);
				exit;
			}
		}

		$company = array(
			"company_name" => $company_name,
			"industry_id" => $industry_id
		);

		$res = array(
			'success' => true,
			'msg' => 'A company has been added successfully.'
		);

		$result = $this->company->create($company);

		if( $result == false ){
			$res['success'] = false;
			$res['msg'] = 'Unable to create a Company right now. Please try again later.';
		}else{
			$company['company_id'] = $result;
			$company['industry_name'] = $industry_name;
			$res['details'] = array(
				"company" => $company
			);
		}

		echo json_encode($res);
	}

	/**
	 * Displays a view to edit a company
	 */
	public function edit($id){
		$this->load->model('admin/Country_model', 'country', true);

		$data = array();
		$data['js_module'] = 'edit_company';
		$data['company'] = $this->company->find($id);
		$data['industries'] = $this->industry->get("industry_id as id, industry_name as text");
		$countries = $this->country->get();
		$data['countries'] = array();
		$data['currencies'] = array();
		$data['_open_to'] = array();
		$data['_locations'] = array();
		$data['open_to'] = $this->company->get_opento($id);
		$data['locations'] = $this->company->get_locations($id);

		foreach ($data['industries'] as $industry) {
			if( $industry->id == $data['company']->industry_id ){
				$data['company']->industry_name = $industry->text;
			}
		}

		foreach ($data['open_to'] as $row) {
			$data['_open_to'][] = array(
				'label' => $row->open_to,
				'value' => $row->open_to_id
			);
		}

		foreach ($countries as $country) {
			if( $country->country_id == $data['company']->country_id ){
				$data['company']->country_name = $country->country_name;
				$data['company']->currency = "$country->currency_name ($country->currency_symbol)";
			}
			
			$currency = new stdClass();
			$currency->label = "$country->currency_name ($country->currency_symbol)";
			$currency->value = $country->country_id;
			$data['currencies'][] = $currency;

			$n_country = new stdClass();
			$n_country->id = $country->country_id;
			$n_country->text = $country->country_name;

			$data['countries'][] = $n_country;
		}

		$target_dir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/company_logos/';
		$imgd = base_url('assets/images/pix.jpg');
		$data['company']->hasImg = '';

		if($data['company']->logo != null) {
			$data['company']->hasImg = 'hasImg';
			$imgd  = base_url('assets/images/company_logos').'/'.$data['company']->logo;
		}

		$data['company']->logo_dir = $target_dir.$data['company']->logo;
		$data['company']->logo = $imgd;
		

		$this->load->view('desktop/admin/edit_company', $data);
	}

	/**
	 * Updates a company
	 */
	public function update(){
		$this->form_validation->set_rules('company_name', 'Company Name', 'xss_clean|required|trim');
		$this->form_validation->set_rules('country_id', 'Country', 'xss_clean|required|trim');
		$this->form_validation->set_rules('industry_id', 'Industry', 'required|trim');
		$this->form_validation->set_rules('currency_id', 'Currency', 'required|trim');

		$response = array(
			'success' => false, 
			'msg' => "No Changes has been saved." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();

			$company = array(
			    "company_name" => $data["company_name"],
			    "telephone_no" => $data["telephone_no"],
			    "fax_no" => $data["fax_no"],
			    "website" => $data["website"],
			    "career_site" => $data["career_site"],
			    "industry_id" => $data["industry_id"],
			    "currency_id" => $data["currency_id"],
			    "country_id" => $data["country_id"],
			    "business_registration_no" => $data["business_registration_no"],
			    "business_address" => $data["business_address"]
			);

			if( $this->company->edit($data["company_id"], $company) ){
				$response['msg'] = 'Your changes have been saved.';
				$response['success'] = true;
			}
		}

		echo json_encode($response);
	}

	public function update_logo($id){
		require_once APPPATH.'libraries/Uploader.php';

		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/assets/images/company_logos/';
		$valid_extensions = array( 'png', 'jpeg', 'jpg');
		$uploader 	= new FileUpload('uploadfile');

		$u_id = $this->input->post('id');
		$ext 	= $uploader->getExtension();
		$uploader->newFileName = $u_id.'.'.$ext;

		// Handle the upload
		$result = $uploader->handleUpload($upload_dir, $valid_extensions);

		if (!$result) {
		  exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
		}

		// save new logo
		$values = array(
			"logo" => $uploader->newFileName
		);

		$this->company->edit($id, $values);

		echo json_encode(
			array('success' => true,
				'newFile' => base_url('assets/images/company_logos/'.$uploader->newFileName) 
			)
		);
	}

	public function delete_logo($id){
		$values = array(
			"logo" => null
		);

		$response = array('success' => false);

		if( $this->company->edit($id, $values) ){
			$response = array('success' => true);
		}

		echo json_encode( $response );
	}

	public function delete(){
		$id = $this->input->post('id');

		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->company->delete($id) ){
			$response['msg'] = 'Company successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

	public function create_opento(){
		$this->form_validation->set_rules('open_to', 'Open To', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New record has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();
			if( $this->company->check_opento($data['open_to'], $data['company_id']) ){
				$response['msg'] = "This record already exists.";
				$response['success'] = false;
			}else{
				$opento = array(
					'open_to' => $data['open_to'],
					'company_id' => $data['company_id'],
					'user_id' => $this->session->userdata('user_id')
				);


				$result = $this->company->create_opento($opento);

				if( $result == false ){
					$response['success'] = false;
					$response['msg'] = 'Unable to save a record right now. Please try again later.';
				}else{
					$opento['open_to_id'] = $result;
					$response['details'] = array(
						"opento" => $opento
					);
				}
			}
		}

		echo json_encode($response);
	}

	public function delete_opento(){
		$id = $this->input->post('id');

		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->company->delete_opento($id) ){
			$response['msg'] = 'A record was successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

	public function create_location($company_id){
        $this->form_validation->set_rules('country_id', 'Country', 'xss_clean|required|trim');
        $this->form_validation->set_rules('city_id', 'City', 'xss_clean|required|trim');
        $this->form_validation->set_rules('town_id', 'Town', 'xss_clean|required|trim');

        $response = array(
            'success' => true, 
            'msg' => "New record has been added." 
        );

        if($this->form_validation->run() != true){
            $response['msg'] = validation_errors();
            $response['success'] = false;
        }else{
            $data = $this->input->post();
            $data['company_id'] = $company_id;

            if( $this->company->check_location($data) ){
                $response['msg'] = "This record already exists.";
                $response['success'] = false;
            }else{
                $location = array(
                    "company_id" => $data['company_id'],
                    "country_id" => $data['country_id'],
                    "state_id" => $data['state_id'],
                    "city_id" => $data['city_id'],
                    "town_id" => $data['town_id'],
                    "train_id" => $data['train_id'],
                    "zone_id" => $data['zone_id']
                );


                $result = $this->company->create_location($location);

                if( $result == false ){
                    $response['success'] = false;
                    $response['msg'] = 'Unable to save a record right now. Please try again later.';
                }else{
                    $new_location = $this->company->find_location($result);
                    $response['details'] = array(
                        "location" => $new_location
                    );
                }
            }
        }

        echo json_encode($response);
    }

    public function delete_location(){
        $id = $this->input->post('id');

        $response = array(
            'success' => false, 
            'msg' => "Sorry, but we can't process your request right now. Please try again later." 
        );

        if( $this->company->delete_location($id) ){
            $response['msg'] = 'A record was successfully deleted.';
            $response['success'] = true;
        }

        echo json_encode($response);
    }

}