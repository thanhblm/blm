<?php

namespace backend\controllers\service;

use common\helper\EmailHelper;
use common\persistence\base\vo\ServiceVo;
use common\persistence\base\vo\StateVo;
use common\persistence\extend\vo\ServiceExtendVo;
use common\services\service\ServiceService;
use common\services\service\StateService;
use common\services\country\CountryService;
use common\utils\FileUtil;
use common\utils\StringUtil;
use core\common\Paging;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

/**
 * *
 *
 * @author TANDT
 *
 */
class ServiceController extends PagingController
{
    public $service;
    public $serviceList; // pagging
    public $fileNameDownload;
    public $listCountry;
    public $listState;
    private $serviceSv;
    private $countrySv;
    private $stateSv;

    public function __construct()
    {
        parent::__construct();
        $this->service = new ServiceVo();
        $this->serviceSv = new ServiceService ();
        $this->filter = new ServiceExtendVo ();
        $this->stateSv = new StateService();
        $this->countrySv = new CountryService();
    }

    public function listView()
    {
        $this->getServices();
        return "success";
    }

    public function search()
    {
        $this->getServices();
        return "success";
    }

    public function addView()
    {
        $this->service = $this->service;
        $this->prepareDataView();
        return "success";
    }

    public function add()
    {
        $this->validAddForm();
        $this->prepareDataView();
        if ($this->hasErrors()) {
            return "success";
        }
        $this->prepareData();
        $this->serviceSv->createService($this->service);
        return "success";
    }

    public function editView()
    {
        $this->detail();
        $this->prepareDataView();
        return "success";
    }

    public function edit()
    {
        $this->validEditData();
        if ($this->hasErrors()) {
            $this->prepareDataView();
            return "success";
        }
        $this->prepareData();
        $this->service->crBy = null;
        $this->service->crDate = null;
        $this->serviceSv->updateService($this->service);
        return "success";
    }

    public function copyView()
    {
        $this->detail();
        $this->service->id = null;
        return "success";
    }

    public function copy()
    {
        $this->validAddData();
        if ($this->hasErrors()) {
            return "success";
        }
        $this->prepareData();
        if (!AppUtil::isEmptyString($this->service->password)) {
            $this->service->password = sha1($this->service->password);
        }
        $this->serviceSv->createService($this->service);
        return "success";
    }

    public function delView()
    {
        $this->detail();
        return "success";
    }

    public function del()
    {
        $this->serviceSv->deleteService($this->service);
        return "success";
    }

    public function exportCSV()
    {
        try {
            $listService = $this->serviceSv->selectAll();
            $fileNameDownload = FileUtil::exportCsvFromObjects($listService, ServiceVo::class);
        } catch (\Exception $e) {
            $this->addActionError($e->getMessage());
            $this->prepareDataView();
            $this->getServices();
            return "error";
        }
        $this->fileNameDownload = $fileNameDownload;
        return "success";
    }

    public function changeCountry()
    {
        $state = new StateVo();
        $state->country = AppUtil::defaultIfEmpty($this->service->country, 0);
        $this->listState = $this->stateSv->selectByFilter($state);
        return "success";
    }

    private function prepareDataView()
    {
        $this->listCountry = $this->countrySv->getAll();
        $state = new StateVo();
        $state->country = AppUtil::defaultIfEmpty($this->service->country, 0);
        $this->listState = $this->stateSv->selectByFilter($state);
    }

    private function prepareData()
    {
        $this->service->type = 2;
        $this->service->crBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
        $this->service->crDate = date('Y-m-d H:i:s');
        $this->service->mdDate = date('Y-m-d H:i:s');
        $this->service->mdBy = empty ($this->getUserInfo()) ? 0 : $this->getUserInfo()->userId;
    }

    private function validEditData()
    {
        $this->validEditForm();
        if (!$this->hasErrors()) {
            $filter = new ServiceVo ();
            $filter->id = $this->service->id;
            $serviceOld = $this->serviceSv->selectByKey($filter);

            if (!isset($serviceOld->id)) {
                $this->addFieldError("service[id]", Lang::getWithFormat("Not found with id {0} !", $this->service->id));
            }
        }
    }

    private function validEditForm()
    {
        if (AppUtil::isEmptyString($this->service->id)) {
            $this->addFieldError("service[id]", Lang::get("ID service can not be empty"));
        }
        if (AppUtil::isEmptyString($this->service->service)) {
            $this->addFieldError("service[service]", Lang::get("Service can not be empty"));
        }
        if (AppUtil::isEmptyString($this->service->email)) {
            $this->addFieldError("service[email]", Lang::get("Email can not be empty"));
        } else if (filter_var($this->service->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->addFieldError("service[email]", Lang::getWithFormat("{0} is not a valid email service", $this->service->email));
        } else if (!EmailHelper::isValidEmailMx($this->service->email)) {
            $this->addFieldError("service[email]", Lang::getWithFormat("{0} is not a valid mx email service", $this->service->email));
        }

        if (AppUtil::isEmptyString($this->service->country) || "0" == $this->service->country) {
            $this->addFieldError("service[country]", Lang::get("Please select a country"));
        }
        if (AppUtil::isEmptyString($this->service->firstName)) {
            $this->addFieldError("service[firstName]", Lang::get("First name can not be empty"));
        } elseif (!StringUtil::validName($this->service->firstName)) {
            $this->addFieldError("service[firstName]", Lang::get("First name can not using speacial character"));
        }
        if (AppUtil::isEmptyString($this->service->lastName)) {
            $this->addFieldError("service[lastName]", Lang::get("Last name can not be empty"));
        } elseif (!StringUtil::validName($this->service->lastName)) {
            $this->addFieldError("service[lastName]", Lang::get("Last name can not using special characters"));
        }
        if (AppUtil::isEmptyString($this->service->phone)) {
            $this->addFieldError("service[phone]", Lang::get("Phone can not be empty"));
        } elseif (!StringUtil::validPhone($this->service->phone)) {
            $this->addFieldError("service[phone]", Lang::get("Phone is not valid"));
        }
        if ($this->service->country == 411 || $this->service->country == 384) {
            if (AppUtil::isEmptyString($this->service->state)) {
                $this->addFieldError("service[state]", Lang::get("State can not be empty"));
            }
        }
    }

    private function validAddForm()
    {
        if (AppUtil::isEmptyString($this->service->email)) {
            $this->addFieldError("service[email]", Lang::get("Email can not be empty"));
        } else if (filter_var($this->service->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->addFieldError("service[email]", Lang::getWithFormat("{0} is not a valid email service", $this->service->email));
        } else if (!EmailHelper::isValidEmailMx($this->service->email)) {
            $this->addFieldError("service[email]", Lang::getWithFormat("{0} is not a valid email service", $this->service->email));
        }

        if (AppUtil::isEmptyString($this->service->country) || "0" == $this->service->country) {
            $this->addFieldError("service[country]", Lang::get("Please select a country"));
        }
        if (AppUtil::isEmptyString($this->service->state) || "0" == $this->service->state) {
            $this->addFieldError("service[state]", Lang::get("Please select a state"));
        }
        if (AppUtil::isEmptyString($this->service->firstName)) {
            $this->addFieldError("service[firstName]", Lang::get("First name can not be empty"));
        } elseif (!StringUtil::validName($this->service->firstName)) {
            $this->addFieldError("service[firstName]", Lang::get("First name can not using speacial character"));
        }
        if (AppUtil::isEmptyString($this->service->lastName)) {
            $this->addFieldError("service[lastName]", Lang::get("Last name can not be empty"));
        } elseif (!StringUtil::validName($this->service->lastName)) {
            $this->addFieldError("service[lastName]", Lang::get("Last name can not using special characters"));
        }
        if (AppUtil::isEmptyString($this->service->phone)) {
            $this->addFieldError("service[phone]", Lang::get("Phone can not be empty"));
        } elseif (!StringUtil::validPhone($this->service->phone)) {
            $this->addFieldError("service[phone]", Lang::get("Phone is not valid"));
        }

        if (AppUtil::isEmptyString($this->service->service)) {
            $this->addFieldError("service[service]", Lang::get("Service can not be empty"));
        }

        if ($this->service->country == 411 || $this->service->country == 384) {
            if (AppUtil::isEmptyString($this->service->state)) {
                $this->addFieldError("service[state]", Lang::get("State can not be empty"));
            }
        }

    }

    private function detail()
    {
        if (AppUtil::isEmptyString($this->service->id)) {
            $this->addActionError(Lang::get("You can't view a service with empty id"));
        } elseif (!is_int(intval($this->service->id))) {
            $this->addActionError(Lang::get("Service id required integer"));
        } else {
            $serviceDetail = $this->serviceSv->selectBykey($this->service);
            if (!isset ($serviceDetail)) {
                $this->addActionError(Lang::getWithFormat("Not found service with id {0}", $this->service->id));
            } else {
                $this->service = $serviceDetail;
            }
        }
    }

    private function getServices()
    {
        $filter = $this->buildFilter();
        $filter->groupId = $this->service->groupId;
        $count = $this->serviceSv->searchCount($filter);
        $paging = new Paging ($count, $this->pageSize, $this->getNLinks(), $this->page);
        $filter->start_record = $paging->startRecord - 1;
        $filter->end_record = $paging->pageSize;
        $paging->records = $this->serviceSv->search($filter);
        $this->serviceList = $paging;
    }

    private function buildFilter()
    {
        $filter = $this->buildBaseFilter("id asc");
        StringUtil::clearObject($filter);
        $filter->type = 2;
        return $filter;
    }
}