<?php
/**
 * Created by PhpStorm.
 * User: bkovach
 * Date: 8/28/16
 * Time: 12:14 PM
 */

namespace App\Controller;


class ToolsController extends AppController {

	public function isAuthorized( $user ) {

		if(
			'committee' == $user['role'] &&
		    in_array( $this->request->param('action'), ['quickAdd'])
		) {
			return true;
		}

		return parent::isAuthorized( $user );
	}

	public function report() {
		$tools = $this->Tools->find();
		$tools
			->select([
				'Tools.tool_id',
				'Tools.title',
				'tool_sum' => $tools->func()->sum('JobTools.count')
			])
			->leftJoin(
				['JobTools' => "jobs_tools"],
				['Tools.tool_id = JobTools.tool_id']
			)
			->group(['Tools.tool_id', 'Tools.title'])
			->order(['Tools.title ASC']);

		$this->set(compact('tools'));

		return;
	}


	public function quickAdd() {
		$tool = null;
		$template = null;

		if( $this->Auth->user('role') == "admin" ){
			if( $this->request->is(['put', 'post'])) {
				$tool = $this->Tools->newEntity($this->request->getData());

				$tool = $this->Tools->save($tool);
				$count = $this->Tools->find('all')->count();
				$template = __('<div class="row tool">
						<div class="column large-8 tool__title">{2}</div>
						<div class="column large-4 tool__count">
							<input name="tools[{0}][tool_id]" id="tools-{0}-tool-id" value="{1}" type="hidden">
							<div class="input number">
								<input name="tools[{0}][_joinData][count]" id="tools-{0}-joindata-count" value="0" type="number">
							</div>
						</div>
					</div>', [
						$count - 1,
						$tool->tool_id,
						$tool->title
				]);
			}
		}

		$this->set('tool', $tool);
		$this->set('template', $template);
		$this->set('_serialize', ['tool', 'template']);
	}

}