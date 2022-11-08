<?php

namespace App\Http\Controllers;

use App\Models\Alerts\Entity\AlertActions;
use App\Models\Alerts\Entity\AlertTrigger;
use App\Models\Cameras\Entity\Camera;
use App\Models\Categories\Entity\Category;
use App\Models\Contributes\Entity\Contribute;
use App\Models\Countries\Entity\country;
use App\Models\Entities\Entity\Entity;
use App\Models\InternetLinks\Entity\InternetLink;
use App\Models\Ministries\Entity\Ministry;
use App\Models\Sites\Entity\Site;
use App\Models\Sources\Entity\Source;
use App\Models\Subcategories\Entity\Subcategory;
use App\Models\Users\Entity\User;
use App\Models\Weights\Entity\Weight;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultController extends Controller
{
    public function getLists(Request $request)
    {
        $request->validate([
            'lists' => 'required',
        ]);


        $results = [];

        foreach (json_decode($request->get('lists')) as $item) {
            switch ($item) {
                case 'entities':
                    $results[$item] = Entity::all()->toArray();
                    break;
                case 'contributes':
                    $results[$item] = Contribute::all()->toArray();
                    break;
                case 'ministries':
                    $results[$item] = Ministry::all()->toArray();
                    break;
                case 'internet_links':
                    $results[$item] = InternetLink::all()->toArray();
                    break;
                case 'subcategories':
                    $results[$item] = Subcategory::all()->toArray();
                    break;
                case 'categories':
                    $results[$item] = Category::all()->toArray();
                    break;
                case 'countries':
                    $results[$item] = country::all()->toArray();
                    break;
                case 'sources':
                    $results[$item] = Source::all()->toArray();
                    break;
                case 'sites':
                    $results[$item] = Site::all()->toArray();
                    break;
                case 'roles':
                    $results[$item] = Role::all()->toArray();
                    break;
                case 'permissions':
                    $results[$item] = Permission::all()->toArray();
                    break;
                case 'users':
                    $results[$item] = User::all()->toArray();
                    break;
            }
        }

       return json_encode(['lists' => $results]);
    }
}
