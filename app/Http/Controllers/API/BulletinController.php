namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulletinController extends Controller
{
    public function store(Request $request, $electionId)
    {
        $request->validate([
            'candidat_id' => 'nullable|exists:candidates,id'
        ]);

        $user = Auth::user();
        $election = Election::findOrFail($electionId);

        $bulletin = $user->voter($election, $request->candidate_id);

        return response()->json($bulletin, 201);
    }
}