<?php
/**
 * @copyright Copyright (c) 2018 John Molakvoæ <skjnldsv@protonmail.com>
 *
 * @author John Molakvoæ <skjnldsv@protonmail.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Contacts\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IRequest;

class PageController extends Controller {

	protected $appName;
	private $userId;

	/**
	 * @var IConfig
	 */
	private $config;

	public function __construct(string $AppName,
								IRequest $request,
								string $UserId = null,
								IConfig $config) {
		parent::__construct($AppName, $request);
		$this->appName = $AppName;
		$this->userId = $UserId;
		$this->config = $config;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * Default routing
	 */
	public function index(): TemplateResponse {
		\OCP\Util::connectHook('\OCP\Config', 'js', $this, 'addJavaScriptVariablesForIndex');
		return new TemplateResponse('contacts', 'main'); // templates/main.php
	}

	/**
	 * add parameters to javascript for user sites
	 *
	 * @param array $array
	 */
	public function addJavaScriptVariablesForIndex(array $array) {
		$appversion = $this->config->getAppValue($this->appName, 'installed_version');

		$array['array']['oca_contacts'] = \json_encode([
			'versionstring' => $appversion,
		]);
	}
}
