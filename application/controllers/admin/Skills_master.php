<?php
require APPPATH."controllers/Base_Controller.php";

class Skills_master extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->module = basename(dirname(__DIR__));
		$this->class = $this->router->class;
		$this->method = $this->router->method;
		$this->module_url = $this->class.'/'.$this->method;

		$this->load->model('admin/Skills_model', 'skills', true);
		$this->load->model("admin/SkillsQualifications_model", "sq", true);
	}

	public function index(){
		$this->load->model("admin/Function_model", "function", true);
		$this->load->model("admin/Qualifications_model", "qualifications", true);

		$data = array();
		$skills = $this->skills->all();
		$data['js_module'] = $this->class;
		$data['functions'] = $this->function->get("function_id as id, function_name as text");
		$data["_skills"] = array();
		$data['qualifications'] = $this->qualifications->get("qualifications_id as id, qualifications_name as text");
		$data['skills_qualifications'] = $this->sq->all();
		$data['skills'] = $skills;

		foreach ($skills as $skill) {
			// $data["_skills"][] = array(
			// 	"label" => $skill->skills_name,
			// 	"value" => $skill->skills_id
			// );

			$data['_skills'][] = array(
				"text" => $skill->skills_name,
				"id" => $skill->skills_id
			);
		}

		$this->load->view('desktop/admin/skills_master', $data);

	}

	public function create(){
		$this->form_validation->set_rules('skills_name', 'Skill Name', 'xss_clean|required|trim|callback__unique_skill');
		$this->form_validation->set_rules('function_id', 'Function', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New skill has been added." 
		);

		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$data = $this->input->post();
			$skill = array(
				'skills_name' => $data['skills_name'],
				'function_id' => $data['function_id'],
				'specialised' => $data['specialised']
			);


			$result = $this->skills->create($skill);

			if( $result == false ){
				$response['success'] = false;
				$response['msg'] = 'Unable to save a skill right now. Please try again later.';
			}else{
				$skill['skills_id'] = $result;
				$response['details'] = array(
					"skill" => $skill
				);
			}

			
		}

		echo json_encode($response);
		
	}

	public function _unique_skill($str) {
		$res = $this->skills->check($str);

		if($res) {
			$this->form_validation->set_message("_unique_skill", "This Skill already exists." );
			return false;
		}
		return true;
	}

	public function _unique_skill_qualification($skills_id, $qualifications_id){
		$res = $this->sq->check($skills_id, $qualifications_id);
		if($res) {
			$this->form_validation->set_message("skills_id", "This qualification already exists." );
			return false;
		}
		return true;
	}

	public function delete(){
		$id = $this->input->post('id');

		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		if( $this->skills->delete($id) ){
			$response['msg'] = 'Successfully deleted.';
			$response['success'] = true;
		}

		echo json_encode($response);
	}

	public function add_skill_qualification(){
		$this->form_validation->set_rules('skills_id', 'Skills', 'xss_clean|required|trim');
		$this->form_validation->set_rules('qualifications_id', 'Qualifications', 'xss_clean|required|trim');

		$response = array(
			'success' => true, 
			'msg' => "New qualification has been added." 
		);

		$data = $this->input->post();

		

		if($this->form_validation->run() != true || $this->_unique_skill_qualification($data['skills_id'], $data['qualifications_id']) == false){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$sq = array(
				'skills_id' => $data['skills_id'],
				'qualifications_id' => $data['qualifications_id']
			);


			$result = $this->sq->create($sq);

			if( $result == false ){
				$response['success'] = false;
				$response['msg'] = 'Unable to process your request right now. Please try again later.';
			}else{
				$sq['skills_qualifications_id'] = $result;
				$response['details'] = array(
					"skills_qualifications" => $sq
				);
			}
		}

		echo json_encode($response);
	}

	public function remove_skill_qualification(){
		$response = array(
			'success' => false, 
			'msg' => "Sorry, but we can't process your request right now. Please try again later." 
		);

		$this->form_validation->set_rules('id', 'Skills Qualifactions ID', 'xss_clean|required|trim');
		if($this->form_validation->run() != true){
			$response['msg'] = validation_errors();
			$response['success'] = false;
		}else{
			$id = $this->input->post('id');
			if( $this->sq->delete($id) ){
				$response['msg'] = 'Successfully deleted.';
				$response['success'] = true;
			}		
		}
		echo json_encode($response);
	}
}