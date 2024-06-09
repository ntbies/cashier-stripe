<?php

namespace Ntbies\CashierStripe\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ntbies\CashierStripe\CashierStripe;

class AccountController extends Controller
{

    public function onboarding(Request $request, int $id)
    {
        $partnerModel = CashierStripe::getPartnerModel();
        $partner = $partnerModel::findOrFail($id);
        if ($request->user()->cannot('update', $partner)) {
            abort(403);
        }
        if (!$partner->hasStripeAccount()) {
            $partner->createStripeAccount();
        }
        return redirect($partner->stripeAccountLink());
    }

    public function dashboard(Request $request, int $id)
    {
        $partnerModel = CashierStripe::getPartnerModel();
        //dd($partnerModel);
        $partner = $partnerModel::findOrFail($id);
        if ($request->user()->cannot('update', $partner)) {
            abort(403);
        }
        if (!$partner->hasStripeAccount()) {
            abort(403);
        }
        return redirect($partner->stripeLoginLink());
    }

}
