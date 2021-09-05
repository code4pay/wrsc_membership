<?php

namespace App\Http\Controllers\Admin;

use App\Models\BackpackUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jimmyjs\ReportGenerator\Facades\ExcelReportFacade as Reporter;
use \Laracsv\Export;
use Illuminate\Support\Facades\DB;


class ReportsController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        if (!backpack_user()->can('Read All')) {
            abort(403, 'You do not have access to this action');
        }
        return view('reports.reports');
    }

    public function run(Request $request)
    {
        if (!backpack_user()->can('Read All')) {
            abort(403, 'You do not have access to this action');
        }
        switch ($request->input('report_name')) {
            case 'immunisation_report':
                return $this->immunisation_report($request);
                break;
            case 'myob_export':
                return $this->myob_export($request);
                break;
            case 'training_report':
                return $this->training_report($request);
                break;
        }

        abort(404, 'No Such Report');
    }

// This was added from a misunderstanding of requirements I left it here just in case it is useful in the future.  

    private function training_documents_export($request)
    {

        app('debugbar')->disable();

        $users = \App\Models\BackpackUser::whereNotNull('documents')->get();
        $trainingDocuments = [];
        foreach ($users as $user) {
            foreach ($user->documents as $document) {
                if (strpos($document, 'TRAIN') !== false) {
                    $docBits = explode('/', $document);
                    preg_match('/TRAIN\s(\w+\s*\w*)\s(\d{4})/', $document, $matches);
                    if (!isset($matches[1])) {
                        $matches[1] = 'Error';
                    }
                    if (!isset($matches[2])) {
                        $matches[2] = 'Error';
                    }
                    $trainingDocuments[] = (object)['document' => $docBits[1], 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'type' => $matches[1], 'year' => $matches[2]];
                }
            }
        }
        $csvExporter = new \Laracsv\Export();
        $columns = [ // Set Column to be displayed
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'document' => 'Document Name',
            'type' => 'Training Type',
            'year'  => 'Year'
        ];
        $csvExporter->build(collect($trainingDocuments), $columns);

        return    $csvExporter->download('Training_Documents.csv');
    }
    private function training_report(Request $request)
    {

        app('debugbar')->disable();
        $records = DB::table('course_users')
            ->select('first_name', 'last_name', 'name', 'course_by', 'comment', 'date_completed') // Do some querying..
            ->join('courses', 'course_id', '=', 'courses.id')
            ->join('users', 'user_id', '=', 'users.id')
            ->where('member_type_id', '<>', 8)->get();
        $csvExporter = new \Laracsv\Export();
        $columns = [ // Set Column to be displayed
            'last_name' => 'Co./Last Name',
            'first_name' => 'First Name',
            'name' => 'Course Name',
            'course_by' => 'Conducted By',
            'date_completed' => 'Date Completed'
        ];
        $csvExporter->build($records, $columns);

        return    $csvExporter->download('training_records.csv');
    }

    private function immunisation_report(Request $request)
    {

        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $sortBy = 'lyssa_serology_date';
        $title = 'Immunisation Report'; // Report title

        $meta = [ // For displaying filters description on header
            'Immunised Since' => $fromDate,
            'Immunised Before' => $toDate,
            'Sort By' => $sortBy
        ];

        $queryBuilder = \App\Models\BackpackUser::select(['first_name', 'last_name', 'lyssa_serology_date', 'lyssa_serology_value', 'lyssa_serology_comment']) // Do some querying..
            ->whereBetween('lyssa_serology_date', [$fromDate, $toDate])
            ->orderBy($sortBy);

        $columns = [ // Set Column to be displayed
            'Name' => 'fullname',
            'lyssa_serology_date',
            'lyssa_serology_value',
            'lyssa_serology_comment'
        ];
        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return Reporter::of($title, $meta, $queryBuilder, $columns)
            ->editColumn('Joined', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function ($result) {
                    return $result->lyssa_serology_date->format('d M Y');
                },
                'class' => 'left'
            ])
            ->download('lyssa_serology_report.xls'); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
        return view('reports.reports');
    }
    private function myob_export(Request $request)
    {

        $fromDate = $request->input('from_date');
        $sortBy = 'joined';
        app('debugbar')->disable();

        $users = \App\Models\BackpackUser::where('joined', '>=', $fromDate)->orderBy('joined')->get();
        $csvExporter = new \Laracsv\Export();
        $columns = [ // Set Column to be displayed
            'last_name' => 'Co./Last Name',
            'first_name' => 'First Name',
            'member_number' => 'Card ID',
            'Card Status',
            'address' => 'Addr 1 - Line 1',
            'Addr 1 - Line 2',
            'Addr 1 - Line 3',
            'Addr 1 - Line 4',
            'city' => 'Addr 1 - City',
            'state' => 'Addr 1 - State',
            'post_code' => 'Addr 1 - Postcode',
            'mobile' => 'Addr 1 - Phone No. 1',
            'home_phone' => 'Addr 1 - Phone No. 2',
            'Addr 1 - Phone No. 3',
            'email' => 'Addr 1 - Email',
        ];
        $csvExporter->build($users, $columns);

        return    $csvExporter->download('myob_export.csv');
    }
}
