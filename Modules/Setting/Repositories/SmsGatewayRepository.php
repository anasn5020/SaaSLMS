<?php

namespace Modules\Setting\Repositories;

use App\Traits\ImageStore;
use Modules\Setting\Entities\SmsGateway;
use Modules\Setting\Entities\SmsGatewayParameter;

class SmsGatewayRepository
{
    use ImageStore;

    public function all()
    {
        return SmsGateway::orderBy('gateway_name', 'asc')->get();
    }

    public function getActiveAll()
    {
        return SmsGateway::where('status', 1)->orderBy('gateway_name', 'asc')->get();
    }

    public function create(array $data)
    {

        if (isset($data['gateway_logo']) && $data['gateway_logo']) {
            $logo_url = $this->saveImage($data['gateway_logo']);
        } else {
            $logo_url = null;
        }

        $gateway = SmsGateway::create([
            'gateway_name' => $data['gateway_name'],
            'gateway_url' => $data['gateway_url'],
            'request_method' => $data['request_method'],
            'set_auth' => $data['set_auth'],
            'add_plus' => $data['add_plus'] ?? 0,
            'send_to_parameter_name' => $data['send_to_parameter_name'],
            'message_to_parameter_name' => $data['message_to_parameter_name'],
            'gateway_logo' => $logo_url,
            'status' => false,
        ]);

        if (isset($data['parameters'])) {
            foreach ($data['parameters'] as $params) {
                if ($params['key'] && $params['value']) {
                    SmsGatewayParameter::create([
                        'gateway_id' => $gateway->id,
                        'key' => $params['key'],
                        'value' => $params['value'],
                    ]);
                }
            }
        }

        return $gateway;

    }

    public function find($id)
    {
        return SmsGateway::with(['params'])->find($id);
    }

    public function params($id)
    {
        return SmsGatewayParameter::where('gateway_id', $id)->get();
    }


    public function update(array $data, $id)
    {
        $row = $this->find($id);

        if (isset($data['gateway_logo']) && $data['gateway_logo']) {
            $this->deleteImage($row->gateway_logo);
            $logo_url = $this->saveImage($data['gateway_logo']);
        } else {
            $logo_url = $row->gateway_logo;
        }

        $row->update([
            'gateway_name' => $data['gateway_name'],
            'gateway_url' => $data['gateway_url'],
            'request_method' => $data['request_method'],
            'set_auth' => $data['set_auth'],
            'add_plus' => $data['add_plus'] ?? 0,
            'send_to_parameter_name' => $data['send_to_parameter_name'],
            'message_to_parameter_name' => $data['message_to_parameter_name'],
            'gateway_logo' => $logo_url,
        ]);
        SmsGatewayParameter::where('gateway_id', $id)->delete();

        if (isset($data['parameters'])) {
            foreach ($data['parameters'] as $params) {
                if ($params['key'] && $params['value']) {
                    SmsGatewayParameter::create([
                        'gateway_id' => $id,
                        'key' => $params['key'],
                        'value' => $params['value'],
                    ]);
                }
            }
        }
        return true;
    }


    public function status(array $data)
    {
        if ($data['status']) {
            SmsGateway::query()->update(['status' => false]);
            SmsGateway::where('id', $data['id'])->update(['status' => true]);
        } else {
            SmsGateway::where('id', $data['id'])->update(['status' => false]);
        }

        return true;

    }

    public function delete($id)
    {
        $row = $this->find($id);
        if ($row->gateway_logo) {
            $this->deleteImage($row->gateway_logo);
        }
        return $row->delete();
    }
}
