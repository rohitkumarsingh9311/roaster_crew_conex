<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\activities;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use Dompdf\Dompdf;





class RosterController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'roster_file' => 'required|mimes:pdf,xlsx,txt,html,ics|max:2048',
        ]);

        $path = $request->file('roster_file')->store('rosters');

        $activities = $this->extractActivities($path);

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
        return redirect()->route('activities')->with('success', 'Roster file uploaded and activities extracted successfully.');
    }
    

    public function showActivities()
    {
        $activities = activities::all();
        return view('activities', compact('activities'));
    }

    private function extractActivities($path)
    {
        $activities = [];
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'pdf':
                $activities = $this->extractActivitiesFromPDF($path);
                break;
            case 'xlsx':
                $activities = $this->extractActivitiesFromExcel($path);
                break;
            case 'txt':
                $activities = $this->extractActivitiesFromTxt($path);
                break;
            case 'html':
                $activities = $this->extractActivitiesFromHtml($path);
                break;
            case 'ics':
                $activities = $this->extractActivitiesFromIcs($path);
                break;
            default:
                break;
        }
    
        return $activities;
    }

    private function extractActivitiesFromPDF($path)
{
    $activities = [];

    $pdf = new Dompdf();
    $pdf->loadHtml(file_get_contents(storage_path('app/' . $path)));
    $pdf->render();
    $pdfText = $pdf->output();

    $text = $this->extractTextFromPDF($pdfText);
    preg_match_all('/(Day Off|Standby|Flight|Check-In|Check-Out|Unknown)\s*(\w+\d+)/', $text, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $activityType = $match[1];
        $flightNumber = $match[2];

        // Add the extracted activity to the activities array
        $activities[] = [
            'activity_type' => $activityType,
            'flight_number' => $flightNumber,
            'start_time' => null, 
            'end_time' => null, 
        ];
    }

    return $activities;
}

    private function extractActivitiesFromExcel($path)
    {
        
    }
    
    private function extractActivitiesFromTxt($path)
    {
        
    }
    
    private function extractActivitiesFromHtml($path)
{
    $activities = [];
    $html = file_get_contents(storage_path('app/' . $path));

    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $activityElements = $dom->getElementsByTagName('div'); // Adjust tag name as per your HTML structure

    foreach ($activityElements as $element) {
        $activityText = $element->textContent;

        if (preg_match('/(Day Off|Standby|Flight|Check-In|Check-Out|Unknown)\s*(\w+\d+)/', $activityText, $matches)) {
            $activityType = $matches[1];
            $flightNumber = $matches[2];

            $activities[] = [
                'activity_type' => $activityType,
                'flight_number' => $flightNumber,
                'start_time' => null, 
                'end_time' => null, 
            ];
        }
    }

    return $activities;
}
    
    private function extractActivitiesFromIcs($path)
    {
        
    }
}
