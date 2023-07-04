<?php

namespace App\Http\Controllers\users\pds;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\users\others;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class OtherController extends Controller
{
    public const LOCAL_STORAGE_FOLDER = "pdsFiles/";
    public const LOCAL_STORAGE_FOLDER_DELETE = "/public/pdsFiles/";
    private $other;
    private $user;

    public function __construct(others $other, User $user)
    {
        $this->other = $other;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $religion= ['Aglipay',
         'Alliance of Bible Christian Communities of the Philippines', 'Assemblies of God', 'Association of Baptist Churches in Luzon, Visayas, and Mindanao', 'Association of Fundamental Baptist Churches in the Philippines', 'Baptist Conference of the Philippines', 'Bible Baptist Church', 'Bread of Life Ministries', 'Buddhist', 'Cathedral of Praise, Incorporated', 'Charismatic Full Gospel Ministries', 'Christ the Living Stone Fellowship', 'Christian and Missionary Alliance Church of the Philippines', 'Christian Missions in the Philippines', 'Church of Christ', 'Church of God World Mission in the Philippines', 'Church of Jesus Christ of the Latter Day Saints', 'Church of the Nazarene', 'Christian Reformed Church in the Philippines, Incorporated', 'Conservative of the Philippine Baptist Church', 'Convention of the Philippine Baptist Church', 'Crusaders of the Divine Church of Christ, Incorporated', 'Door of Faith', 'Evangelical Christian Outreach Foundation', 'Evangelical Free Church of the Philippines', 'Evangelical Presbyterian Church', 'Faith Tabernacle Church (Living Rock Ministries)', 'Filipino Assemblies of the First Born, Incorporated', 'Foursquare Gospel Church in the Philippines', 'Free Believers in Christ Fellowship', 'Free Methodist Church', 'Free Mission in the Philippines, Incorporated', 'General Baptist Churches of the Philippines', 'Good News Christian Churches', 'Higher Ground Baptist Mission', 'IEMELIF Reform Movement', 'Iglesia Evangelica Unida de Cristo', 'Iglesia Evangelista Methodista en Las Islas Filipinas (IEMELIF)', 'Iglesia Filipina Independiente', 'Iglesia ni Cristo', 'Iglesia sa Dios Espiritu Santo, Incorporated', 'Independent Baptist Churches of the Philippines', 'Independent Baptist Missionary Fellowship', 'International One Way Outreach', 'Islam', 'Jehovah\'s Witness', 'Jesus Christ Saves Global Outreach', 'Jesus is Alive Community, Incorporated', 'Jesus is Lord Church', 'Jesus Reigns Ministries', 'Love of Christ International Ministries', 'Lutheran Church of the Philippines', 'Miracle Life Fellowship International', 'Miracle Revival Church of the Philippines', 'Missionary Baptist Churches of the Philippines', 'Pentecostal Church of God Asia Mission', 'Philippine Benevolent Missionaries Association', 'Philippine Ecumenical Christian Church', 'Philippine Episcopal Churche', 'Philippine Evangelical Mission', 'Philippine General Council of the Assemblies of God', 'Philippine Good News Ministries', 'Philippine Grace Gospel', 'Philippine Independent Catholic Church', 'Philippine Missionary Fellowship', 'Philippine Pentecostal Holiness Church', 'Potter\'s House Christian Center', 'Presbyterian Church in the Philippines', 'Roman Catholic, including Catholic Charismatic', 'Salvation Army, Philippines', 'Seventh Day Adventist', 'Southern Baptist Church', 'Take the Nation for Jesus Global Ministries (Corpus Christi)', 'Things to Come', 'UNIDA Evangelical Church', 'United Church of Christ in the Philippines', 'United Evangelical Church of the Philippines (Chinese)', 'Union Espiritista Cristiana de Filipinas, Incorporated', 'United Methodists Church', 'United Pentecostal Church (Philippines), Incorporated', 'Universal Pentecostal Church', 'Victory Chapel Christian Fellowship', 'Watch Tower Bible and Tract Society of the Philippines, Incorporated (Jehovah\'s Witnesses)', 'Way of Salvation', 'Way of Salvation Church Incorporated, The', 'Wesleyan Church, The', 'Word for the World', 'Word International Ministries, Incorporated', 'World Missionary Evangelism', 'Worldwide Church of God', 'Zion Christian Community Church', 'Other Baptists', 'Other Evangelical Churches', 'Other Methodists', 'Other Protestants', 'Tribal religions', 'Other religious affiliations'];

        $other = $this->other->where('user_id', Auth::user()->id)->first();
        return view('users.PDS.other')->with('edit_other', $other)->with('religion', $religion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->other->user_id = Auth::user()->id;
        $this->other->Q34a = $request->Q34a;
        $this->other->Q34b = $request->Q34b;
        $this->other->Q34b1 = $request->Q34b1;
        $this->other->Q35a = $request->Q35a;
        $this->other->Q35a1 = $request->Q35a1;
        $this->other->Q35b = $request->Q35b;
        $this->other->Q35b1 = $request->Q35b1;
        $this->other->Q35b2 = $request->Q35b2;
        $this->other->Q36a = $request->Q36a;
        $this->other->Q36a1 = $request->Q36a1;
        $this->other->Q37a = $request->Q37a;
        $this->other->Q37a1 = $request->Q37a1;
        $this->other->Q38a = $request->Q38a;
        $this->other->Q38a1 = $request->Q38a1;
        $this->other->Q39a = $request->Q39a;
        $this->other->Q39a1 = $request->Q39a1;
        $this->other->Q40a = $request->Q40a;
        $this->other->Q40a1 = $request->Q40a1;
        $this->other->Q40b = $request->Q40b;
        $this->other->Q40b1 = $request->Q40b1;
        $this->other->Q40c = $request->Q40c;
        $this->other->Q40c1 = $request->Q40c1;
        $this->other->Rname1 = $request->Rname1;
        $this->other->Rname2 = $request->Rname2;
        $this->other->Rname3 = $request->Rname3;
        $this->other->Radd1 = $request->Radd1;
        $this->other->Radd2 = $request->Radd2;
        $this->other->Radd3 = $request->Radd3;
        $this->other->Rtel1 = $request->Rtel1;
        $this->other->Rtel2 = $request->Rtel2;
        $this->other->Rtel3 = $request->Rtel3;
        $this->other->IDa1 = $request->IDa1;
        $this->other->IDa2 = $request->IDa2;
        $this->other->IDb1 = $request->IDb1;
        $this->other->IDb2 = $request->IDb2;
        $this->other->IDc1 = $request->IDc1;
        $this->other->IDc2 = $request->IDc2;

        if ($this->other->save()) {
            Session::flash('alert', 'success|Record has been Saved');
            return redirect()->route('users.pds.other.index');
        } else {
            Session::flash('alert', 'danger|Record not Saved');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $other = $this->other->findOrFail($id);
        $other->Q34a = $request->Q34a;
        $other->Q34b = $request->Q34b;
        $other->Q34b1 = $request->Q34b1;
        $other->Q35a = $request->Q35a;
        $other->Q35a1 = $request->Q35a1;
        $other->Q35b = $request->Q35b;
        $other->Q35b1 = $request->Q35b1;
        $other->Q35b2 = $request->Q35b2;
        $other->Q36a = $request->Q36a;
        $other->Q36a1 = $request->Q36a1;
        $other->Q37a = $request->Q37a;
        $other->Q37a1 = $request->Q37a1;
        $other->Q38a = $request->Q38a;
        $other->Q38a1 = $request->Q38a1;
        $other->Q38b = $request->Q38b;
        $other->Q38b1 = $request->Q38b1;
        $other->Q39a = $request->Q39a;
        $other->Q39a1 = $request->Q39a1;
        $other->Q40a = $request->Q40a;
        $other->Q40a1 = $request->Q40a1;
        $other->Q40b = $request->Q40b;
        $other->Q40b1 = $request->Q40b1;
        $other->Q40c = $request->Q40c;
        $other->Q40c1 = $request->Q40c1;
        $other->Rname1 = $request->Rname1;
        $other->Rname2 = $request->Rname2;
        $other->Rname3 = $request->Rname3;
        $other->Radd1 = $request->Radd1;
        $other->Radd2 = $request->Radd2;
        $other->Radd3 = $request->Radd3;
        $other->Rtel1 = $request->Rtel1;
        $other->Rtel2 = $request->Rtel2;
        $other->Rtel3 = $request->Rtel3;
        $other->IDa1 = $request->IDa1;
        $other->IDa2 = $request->IDa2;
        $other->IDb1 = $request->IDb1;
        $other->IDb2 = $request->IDb2;
        $other->IDc1 = $request->IDc1;
        $other->IDc2 = $request->IDc2;
        if ($other->save()) {
            Session::flash('alert', 'success|Record has been Saved');
            return redirect()->route('users.pds.other.index');
        } else {
            Session::flash('alert', 'danger|Record not Saved');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
