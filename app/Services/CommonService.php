<?php
namespace App\Services;

use Illuminate\Support\Carbon;

use function PHPUnit\Framework\isNan;

class CommonService{
    /**
     * Fungsi untuk mengambil query yang sering digunakan
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi data query yang akan diambil
     * @return array Associative array yang berisi data query yang berhasil diambil
     */
    public function getQuery($request){
        $perPage = (int) $request->input("per_page", 10);
        $page = (int) $request->input("page", 1);
        $order = $request->input("order", "created_at");
        $sort = $request->input("sort", "desc");
        $value = $request->input("value");
        $status = $request->input("status");
        $start = $request->input("start", null);
        $end = $request->input("end", null);

        if(!is_null($start)) $start = Carbon::parse($start);
        if(!is_null($end)) {
          $end = Carbon::parse($end);
          $end->setTime(23, 59, 59);
        }

        return [
            "perPage" => $perPage,
            "page" => $page,
            "order" => $order,
            "sort" => $sort,
            "value" => $value,
            "status" => $status,
            "start" => $start,
            "end" => $end,
        ];
    }

    /**
     * Fungsi untuk mengubah output dari model eloquent menjadi array
     *
     * @param \Illuminate\Database\Eloquent\Collection $getData Output dari model eloquent
     * @return array Array yang berisi data dari `$getTenant`
     */
    public function toArray($getData){
        $dataArr = [];
        foreach($getData as $dataObj){
            array_push($dataArr, $dataObj);
        }

        return $dataArr;
    }

    /**
     * Fungsi untuk mengambil data yang belum dihapus berdasarkan `$id` yang diberikan.
     *
     * @param string $modelPath Path ke model yang akan digunakan untuk mengambil data
     * @param mixed $id Id dari data yang akan diambil
     * @return array Associative array yang berisi data query yang berhasil diambil
     */
    public function getDataById(string $modelPath, $id){
        $model = new $modelPath;
        $getData = $model::where("id", $id)->where("deleted_at", null)->first();
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        return $getData;
    }

    /**
     * Fungsi untuk mengecek apakah string yang berisi id classification atau scope ada
     *
     * @param string $idStr String yang berisi id yang akan divalidasi
     * @param string $dataType Tipe dari data yang akan dicek
     * @return string String yang berisi pesan error
     */
    public function checkIfClassficationOrScopeExist($idStr, $dataType){
        $modelPath = "";
        if(strtolower($dataType) == "classification") $modelPath = "App\Models\Classification";
        else if(strtolower($dataType) == "scope") $modelPath = "App\Models\Scope";
        else return "Data type tidak ditemukan";

        $idArr = array_map('intval', explode(',', preg_replace('/\s+/', '', $idStr)));
        foreach($idArr as $id){
            if(!is_numeric($id)) return "Id tidak valid";

            $dataExist = $this->getDataById($modelPath, $id);
            if(is_null($dataExist)) return $dataType . " tidak ditemukan";
        }

        return "";
    }

    /**
     * Fungsi untuk mengambil data nama classification atau scope
     *
     * @param string $idStr String yang berisi id yang akan divalidasi
     * @param string $dataType Tipe dari data yang akan dicek
     * @return string String yang nama classification atau scope
     */
    public function getClassificationOrScope($idStr, $dataType){
        $modelPath = "";
        if(strtolower($dataType) == "classification") $modelPath = "App\Models\Classification";
        else if(strtolower($dataType) == "scope") $modelPath = "App\Models\Scope";
        else return "Data type tidak ditemukan";

        $dataName = "";
        $idArr = array_map('intval', explode(',', preg_replace('/\s+/', '', $idStr)));

        foreach($idArr as $id){
            if(!is_numeric($id)) continue;

            $dataExist = $this->getDataById($modelPath, $id);
            if(is_null($dataExist)) continue;

            if($dataName == "") $dataName = $dataExist["name"];
            else $dataName = $dataName . ", " . $dataExist["name"];
        }

        return $dataName;
    }
}
