<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use App\Staffgauge;
use App\Ocr;
class MapController extends Controller
{   
  public function locations()
  {
    $locations = Location::get();
    return response()->json($locations); 
  }
  public function staffgauges()
  {
    $staffgauges = Staffgauge::get();
    return response()->json($staffgauges);
  }
  public function ocrs()
  {
    $ocrs = Ocr::get();
    return response()->json($ocrs);
  }
  public function ocrsid()
  {
    $staffgaugeid = $requestData['staffgaugeid'];
    $ocrsid = Ocr::where("staffguageid" , $staffgaugeid);
    return response()->json($ocrsid);
  }
}
