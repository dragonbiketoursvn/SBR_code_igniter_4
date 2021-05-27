<?php

namespace App\Controllers\Admin;

use App\Entities\Appointment;

class Appointments extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\AppointmentsModel;
    }

    public function showAll()
    {
      $scheduledAppointments = $this->model->getScheduledAppointments();
      $appointmentTimes = [];

      foreach ($scheduledAppointments as $scheduledAppointment) {
        $appointmentTimes[] = $scheduledAppointment->appointment_time;
      }

      return view('Admin/Appointments/showAll', ['appointmentTimes' => $appointmentTimes]);
    }

    public function getDetails($dateString)
    {
      $appointment = $this->model->where('appointment_time', $dateString)->first();

      //return view('Admin/Appointments/details', ['appointment' => $appointment]);
      return redirect()->to(site_url("Admin/Appointments/showDetails/{$dateString}"));
    }

    public function showDetails($dateString)
    {
      $appointment = $this->model->where('appointment_time', $dateString)->first();

      return view('Admin/Appointments/showDetails', ['appointment' => $appointment]);

    }

    public function startInteraction($id)
    {
      return redirect()->to(site_url("Admin/Appointments/paymentCheck/{$id}"));
    }

    public function paymentCheck($id)
    {
      $appointment = $this->model->find($id);

       return view('Admin/Appointments/paymentCheck', ['appointment' => $appointment]);
    }

    public function startBikeStatusCheck($id)
    {
      return redirect()->to(site_url("Admin/Appointments/bikeStatusCheck/{$id}"));
    }

    public function bikeStatusCheck($id)
    {
      $appointment = $this->model->find($id);

       return view('Admin/Appointments/bikeStatusCheck', ['appointment' => $appointment]);
    }

    public function startFinalCheck($id)
    {
      return redirect()->to(site_url("Admin/Appointments/finalCheck/{$id}"));
    }

    public function finalCheck($id)
    {
      $appointment = $this->model->find($id);

       return view('Admin/Appointments/finalCheck', ['appointment' => $appointment]);
    }

    /*
    public function index()
	  {
        $users = $this->model->orderBy('id')
                             ->paginate(5);

		return view('Admin/Users/index', [
            'users' => $users,
            'pager' => $this->model->pager
        ]);
    }

    public function show($id)
    {
        $user = $this->getUserOr404($id);

		return view('Admin/Users/show', [
            'user' => $user
        ]);
	}

    public function new()
	{
        $user = new User;

		return view('Admin/Users/new', [
		    'user' => $user
        ]);
	}

	public function create()
	{
        $user = new User($this->request->getPost());

		if ($this->model->protect(false)
                        ->insert($user)) {

			return redirect()->to("/admin/users/show/{$this->model->insertID}")
                             ->with('info', lang('AdminUsers.create_successful'));

        } else {

			return redirect()->back()
							 ->with('errors', $this->model->errors())
                             ->with('warning', lang('App.messages.invalid'))
							 ->withInput();
		}
	}

    public function edit($id)
	{
		$user = $this->getUserOr404($id);

		return view('Admin/Users/edit', [
            'user' => $user
        ]);
	}

    public function update($id)
	{
        $user = $this->getUserOr404($id);

		$post = $this->request->getPost();

        if (empty($post['password'])) {

            $this->model->disablePasswordValidation();

            unset($post['password']);
            unset($post['password_confirmation']);
        }

		$user->fill($post);

		if ( ! $user->hasChanged()) {

            return redirect()->back()
                             ->with('warning', lang('App.messages.no_change'))
                             ->withInput();
		}

        if ($this->model->protect(false)
                        ->save($user)) {

	        return redirect()->to("/admin/users/show/$id")
                             ->with('info', lang('AdminUsers.update_successful'));

		} else {

            return redirect()->back()
                             ->with('errors', $this->model->errors())
                             ->with('warning', lang('App.messages.invalid'))
							 ->withInput();

		}
	}

    public function delete($id)
	{
        $user = $this->getUserOr404($id);

        if ($this->request->getMethod() === 'post') {

            $this->model->delete($id);

			return redirect()->to('/admin/users')
                             ->with('info', lang('AdminUsers.deleted'));
		}

		return view('Admin/Users/delete', [
            'user' => $user
        ]);
	}

    private function getUserOr404($id)
	{
        $user = $this->model->where('id', $id)
                            ->first();

		if ($user === null) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException(lang('AdminUsers.user_not_found') . ': ' . $id);

		}

		return $user;
	}
    */
}
