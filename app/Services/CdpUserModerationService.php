<?php

namespace App\Services;

use App\Models\CdpUsers;
use App\Services\Contracts\CdpUserModerationServiceInterface;

class CdpUserModerationService implements CdpUserModerationServiceInterface
{


    public function filterUsersByMall($filter,$mall, $user)
    {
        switch ($filter)
        {
            case 'id':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'id', 'ASC', $mall );
            case 'reverse_id':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'id', 'desc', $mall);
            case 'created':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'created_at', 'ASC', $mall);
            case 'reverse_created':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'created_at', 'desc', $mall);
            case 'all':
                return (new \App\Models\CdpUsers)->polymorph();
            case 'name':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'name', 'ASC', $mall);
            case 'reverse_name':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'name', 'desc', $mall);
            case 'email':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'email', 'ASC', $mall);
            case 'reverse_email':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'email', 'desc', $mall);
            case 'phone':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'phone', 'ASC', $mall);
            case 'reverse_phone':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_users', 'phone', 'desc', $mall);
            case 'orders':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_user_orders_counts', 'count_unactivated', 'ASC', $mall);
            case 'reverse_orders':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_user_orders_counts', 'count_unactivated', 'desc', $mall);
            case 'bonuses':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_user_bonus_balances', 'balance', 'ASC', $mall);
            case 'reverse_bonuses':
                return (new \App\Models\CdpUsers)->polymorphFiltrationByMall('cdp_user_bonus_balances', 'balance', 'desc', $mall);
        }
    }

    public function filterUsers($filter, $user)
    {
        switch ($filter)
        {
            case 'id':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'id', 'ASC' );
            case 'reverse_id':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'id', 'desc');
            case 'created':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'created_at', 'ASC');
            case 'reverse_created':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'created_at', 'desc');
            case 'all':
                return (new \App\Models\CdpUsers)->polymorph();
            case 'name':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'name', 'ASC');
            case 'reverse_name':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'name', 'desc');
            case 'email':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'email', 'ASC');
            case 'reverse_email':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'email', 'desc');
            case 'phone':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'phone', 'ASC');
            case 'reverse_phone':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_users', 'phone', 'desc');
            case 'orders':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_user_orders_counts', 'count_unactivated', 'ASC');
            case 'reverse_orders':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_user_orders_counts', 'count_unactivated', 'desc');
            case 'bonuses':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_user_bonus_balances', 'balance', 'ASC');
            case 'reverse_bonuses':
                return (new \App\Models\CdpUsers)->polymorphFiltration('cdp_user_bonus_balances', 'balance', 'desc');
        }
    }
}
