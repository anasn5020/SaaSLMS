<?php

namespace Modules\Setting\Repositories;

use App\Traits\ImageStore;
use App\Traits\UploadMedia;
use Modules\Setting\Entities\PayoutAccount;
use Modules\Setting\Entities\PayoutAccountSpecification;

class PayoutAccountRepository
{
    use ImageStore;

    use UploadMedia;

    public function all()
    {
        return PayoutAccount::with(['specifications'])->withCount(['specifications'])->orderBy('title', 'asc')->get();
    }

    public function getActiveAll()
    {
        return PayoutAccount::with(['specifications'])->withCount(['specifications'])->where('status', 1)->orderBy('title', 'asc')->get();
    }

    public function create(array $data)
    {

        $payout_account = PayoutAccount::create([
            'title' => $data['title'],
            'logo' => null,
        ]);
        if (isset($data['logo']) && $data['logo']) {
            $payout_account->logo = $this->generateLink($data['logo'], $payout_account->id, get_class($payout_account), 'logo');
            $payout_account->save();
        }
        if (isset($data['specifications'])) {
            foreach ($data['specifications'] as $specification) {
                if ($specification['specification']) {
                    PayoutAccountSpecification::create([
                        'payout_accounts_id' => $payout_account->id,
                        'title' => $specification['specification'],
                    ]);
                }
            }
        }

        return $payout_account;

    }

    public function find($id)
    {
        return PayoutAccount::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $row = $this->find($id);


        $row->update([
            'title' => $data['title'],
            'logo' => null,
        ]);

        if (isset($data['logo']) && $data['logo']) {
            $row->logo = $this->generateLink($data['logo'], $row->id, get_class($row), 'logo');
            $row->save();
        }

        PayoutAccountSpecification::where('payout_accounts_id', $id)->delete();
        if (isset($data['specifications'])) {
            foreach ($data['specifications'] as $specification) {
                if ($specification['specification']) {
                    PayoutAccountSpecification::create([
                        'payout_accounts_id' => $id,
                        'title' => $specification['specification'],
                    ]);
                }

            }
        }

        return true;
    }

    public function delete($id)
    {
        $row = $this->find($id);

        return $row->delete();
    }
}
