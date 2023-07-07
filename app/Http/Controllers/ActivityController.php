<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
	public function getActivityType(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['activities_type'] = Activity::all();	
		return view('admin.activity.type.index', $data);
	}

	public function showCreateActivityTypeForm(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
		$data['days'] = array_values(CommonUtil::getDayOptions());
		return view('admin.activity.type.form', $data);	
	}

	public function showUpdateActivityTypeForm(Request $request, $id)
	{
		$current_record = Activity::find($id);
		if (empty($current_record))
			return back()
				->with(['error' => 'Gagal mengupdate jenis kegiatan, entitas tidak ditemukan']);
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['days'] = array_values(CommonUtil::getDayOptions());
		$current_record->start_time = date("Y-m-d\TH:i", $current_record->start_time);  
		$current_record->end_time = date("Y-m-d\TH:i", $current_record->end_time);  
		$data['item'] = $current_record;	
		$data['selected_days'] =  array_keys(CommonUtil::getDayOptionsFromValue($current_record->recurring_days));
		return view('admin.activity.type.form', $data);	
	}

	public function createActivityType(Request $request)
	{
		$user_input_field_rules = [
			'name' => 'required',
			'description' => 'required',
			'start_time' => 'required|date_format:Y-m-d\TH:i',
			'end_time'	=> 'required|date_format:Y-m-d\TH:i|lte:start_time'
		];
		$user_input = $request->only('name', 'description', 'start_time', 'end_time', 'leader');
		
		// validate in same month
		if (date('M', strtotime($user_input['start_time'])) != date('M', strtotime($user_input['end_time'])))
		{
			return back()
						->with(['error' => 'Jadwal kegiatan harus didalam bulan yang sama'])
						->withInput();
		}

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if (!$request->hasFile('banner'))
			return back()->withErrors(['banner' => 'Banner wajib di isi'])
							->withInput();

		if (!$request->hasFile('icon'))
			return back()->withErrors(['icon' => 'Icon wajib di isi'])
							->withInput();
		
		$filename = time() . '.' . $request->file('banner')->getClientOriginalExtension();
		$path = $request->file('banner')->storeAs('public/activity', $filename);
		if (empty($path))
		{
			return back()->withErrors(['banner' => 'Gagal mengupload banner'])
						->withInput();
		}
		
		$user_input['banner'] = $filename;

		$filename = time() . '.' . $request->file('icon')->getClientOriginalExtension();
		$path = $request->file('icon')->storeAs('public/activity', $filename);
		if (empty($path))
		{
			return back()->withErrors(['icon' => 'Gagal mengupload icon'])
						->withInput();
		}
		$user_input['icon'] = $filename;
		$user_input['recurring'] = FALSE;
		if ($request->has('recurring') && $request->has('recurring_days'))
		{
			$selected_days = $request->input('recurring_days');
			$user_input['recurring'] = TRUE;
			$user_input['recurring_days'] = CommonUtil::getDayValueFromCheckOptionIds($selected_days);
		}
		
		if ($request->has('show_landing_page')) $user_input['show_landing_page'] = TRUE;
		
		$user_input['start_time'] = strtotime($request->input('start_time'));
		$user_input['end_time'] = strtotime($request->input('end_time'));
		
		$result = Activity::create($user_input);
		if ($user_input['recurring'] && $user_input['recurring_days'])
			$this->_createSchedule($request->start_time, $request->end_time, $request->input('recurring_days'), $result->id);
		return redirect()
					->route('activity.type.index')
					->with(['success' => 'Berhasil menambahkan jenis kegiatan baru']);
	}

	private function _createSchedule($start_time, $end_time, $recurring_days, $activity_id)
	{
		Schedule::where('activity_id', $activity_id)->delete();
		$dates = CommonUtil::getDatesFromRange($start_time, $end_time);
		$schedule_time_start = date('H:i', strtotime($start_time));
		$schedule_time_end = date('H:i', strtotime($end_time));
		$created_records = [];
		foreach ($dates as $date) 
		{
			$current_day = date('l', strtotime($date));
			if (in_array(strtolower($current_day), $recurring_days))
			{
				$created_records[] = [
					'activity_id' => $activity_id,
					'scheduled_date' => $date,
					'scheduled_start_time' => $schedule_time_start,
					'scheduled_end_time' => $schedule_time_end];
			}
		}
		Schedule::insert($created_records);
	}

	public function updateActivityType(Request $request)
	{
		$current_record = Activity::find($request->id);
		if (empty($current_record))
			return back()
					->with(['error' => 'Berhasil mengupdate jenis kegiatan, entitas tidak ditemukan']);
		
		$user_input_field_rules = [
			'name' => 'required',
			'description' => 'required',
			'start_time' => 'required|date_format:Y-m-d\TH:i',
			'end_time'	=> 'required|date_format:Y-m-d\TH:i|lte:start_time'
		];
		$user_input = $request->only('name', 'description', 'start_time', 'end_time', 'leader');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if ($request->hasFile('banner'))
		{
			$filename = time() . '.' . $request->file('banner')->getClientOriginalExtension();
			$path = $request->file('banner')->storeAs('public/activity', $filename);
			if (empty($path))
			{
				return back()->withErrors(['banner' => 'Gagal mengupload banner'])
							->withInput();
			}
			$file_location = 'public/activity/' . CommonUtil::getFileName($current_record->banner);
			Storage::delete($file_location);
			$user_input['banner'] = $filename;
		}

		if ($request->hasFile('icon'))
		{
			$filename = time() . '.' . $request->file('icon')->getClientOriginalExtension();
			$path = $request->file('icon')->storeAs('public/activity', $filename);
			if (empty($path))
			{
				return back()->withErrors(['icon' => 'Gagal mengupload icon'])
							->withInput();
			}
			$file_location = 'public/activity/' . CommonUtil::getFileName($current_record->icon);
			Storage::delete($file_location);
			$user_input['icon'] = $filename;
		}

		$user_input['recurring'] = FALSE;
		if ($request->has('recurring_days') && count($request->input('recurring_days')) > 0)
		{
			$selected_days = $request->input('recurring_days');
			$user_input['recurring'] = TRUE;
			$user_input['recurring_days'] = CommonUtil::getDayValueFromCheckOptionIds($selected_days);
		}
		
		if (!$user_input['recurring'])
		{
			$user_input['recurring'] = FALSE;
			$user_input['recurring_days'] = 0;
		}
		
		if ($request->has('show_landing_page')) $user_input['show_landing_page'] = TRUE;
		
		$user_input['start_time'] = strtotime($request->input('start_time'));
		$user_input['end_time'] = strtotime($request->input('end_time'));
		
		Activity::where('id', $current_record->id)
				->update($user_input);
		if ($user_input['recurring'] && count($user_input['recurring_days']))
		{
			$this->_createSchedule($request->start_time, $request->end_time, $request->input('recurring_days'), $current_record->id);
		}
		if ($user_input['recurring'] == FALSE)
		{
			Schedule::where('activity_id', $current_record->id)->delete();
		}
		return redirect()
					->route('activity.type.index')
					->with(['success' => 'Berhasil mengupdate jenis kegiatan']);
	}

	public function getSchedule(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['activity'] = Activity::all();
		return view('admin.activity.schedule.index', $data);	
	}

	public function getScheduleList(Request $request)
	{
		$data = Schedule::with('activity')->get();
		$schedules = [];
		foreach($data as $item) {
			if (array_key_exists($item->scheduled_date, $schedules))
			{
				$schedules[$item->scheduled_date][] = $item;
				continue;
			}
			$schedules[$item->scheduled_date] = [$item];
		}
		return response()->json([
			'data' => $schedules,
			'message' => 'Berhasil mendapatkan jadwal kegiatan'
		]);
	}

	public function createSchedule(Request $request)
    {
		$user_input_field_rules = [
            'activity_id' => 'required',
            'scheduled_date' => 'required|date_format:Y-m-d',
			'scheduled_start_time' => 'required|date_format:H:i',
			'leader' => 'required',
			'scheduled_end_time' => 'required|date_format:H:i'
        ];

		$user_input = $request->only('activity_id', 'scheduled_date', 'scheduled_start_time', 'scheduled_end_time', 'leader');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
		{
			return response()->json([
				'success' => FALSE,
				'message' => 'Input tidak sesuai',
				'data' => $validator->errors()->all()
			], 400); 
		}

		$unix_schedule_start_time = strtotime(sprintf('%s %s', $user_input['scheduled_date'], $user_input['scheduled_start_time']));
		$unix_schedule_end_time = strtotime(sprintf('%s %s', $user_input['scheduled_date'], $user_input['scheduled_end_time']));

		

		$activity_record = Activity::find($user_input['activity_id']);
		if ($unix_schedule_start_time < $activity_record->start_time || $unix_schedule_end_time > $activity_record->end_time)
		{
			return response()->json([
				'success' => FALSE,
				'message' => 'Tidak bisa membuat jadwal diluar jangkauan jadwal kegiatan',
				'data' => $validator->errors()->all()
			], 400); 		
		}
		if ($activity_record->recurring)
		{
			return response()->json([
				'success' => FALSE,
				'message' => 'Tidak bisa membuat jadwal berulang',
				'data' => $validator->errors()->all()
			], 400); 	
		}
        
		Schedule::create($user_input);
		Session::flash('success', 'Berhasil membuat jadwal');
        return response()->json([
			'success' => TRUE,
            'message' => 'Schedule berhasil dibuat',
            'data' => $user_input
        ]);
    }

	public function deleteSchedule(Request $request, $scheduleId)
	{
		$current_record = Schedule::where('id', $scheduleId)->with('activity')->first();
		if ($current_record->activity->recurring)
		{
			return response()->json([
				'data' => [],
				'success' => FALSE,
				'message' => 'Jadwal berulang tidak bisa dihapus'
			], 400);	
		}

		$current_record->delete();
		
		return response()->json([
			'data' => [],
			'message' => 'Berhasil menghapus jadwal'
		]);
	}

	public function updateSchedule(Request $request)
	{
		$user_input_field_rules = [
			'activity_id' => 'required',
			'id_schedule' => 'required',
			'leader' => 'required',
			'scheduled_date' => 'required',
			'scheduled_end_time' => 'required',
			'scheduled_start_time' => 'required'
		];
		$user_input = $request->only('activity_id', 'id_schedule', 'leader', 'scheduled_date', 'scheduled_end_time', 'scheduled_start_time');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
		{
			return response()->json([
				'success' => FALSE,
				'message' => 'Input tidak sesuai',
				'data' => $validator->errors()->all()
			], 400); 
		}

		$current_record = Schedule::with('activity')->where('id', $user_input['id_schedule'])->first();
		unset($user_input['id_schedule']);
		if (empty($current_record))
		{
			return response()->json([
				'success' => FALSE,
				'message' => 'Entitas tidak ditemukan',
			], 404); 
		}

		if ($current_record->activity->recurring)
		{
			$allowed_field_to_update = ['leader'];
			foreach($user_input as $key => $value)
			{
				if (!in_array($key, $allowed_field_to_update))
					unset($user_input[$key]);
			}
		} else 
		{
			$allowed_field_to_update = ['leader', 'scheduled_date', 'scheduled_end_time', 'scheduled_start_time'];
			foreach($user_input as $key => $value)
			{
				if (!in_array($key, $allowed_field_to_update))
					unset($user_input[$key]);
			}	
		}

		Schedule::where('id', $current_record->id)->update($user_input);
		
		return response()->json([
			'data' => [],
			'success' => TRUE,
			'message' => 'Berhasil mengupdate jadwal'
		]);
	}
}
