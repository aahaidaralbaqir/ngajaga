@extends('layout.dashboard')
@section('content')
<div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
@include('partials.alert')
@include('partials.breadcumb', ['title' => 'Jadwal Kegiatan'])
<div id="calendar" class="w-full max-w-full rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    
</div>
{{-- Modal --}}
<div x-transition="" class="modal hidden fixed top-0 left-0 z-99999 flex h-screen w-full justify-center overflow-y-scroll bg-black/80 py-5 px-4">
  <div class="relative m-auto w-full max-w-180 rounded-sm border border-stroke bg-gray p-4 shadow-default dark:border-strokedark dark:bg-meta-4 sm:p-8 xl:p-10">
    <button class="close-modal absolute right-1 top-1 sm:right-5 sm:top-5">
      <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z" fill=""></path>
      </svg>
    </button>

    <form action="#" method="POST" id="form-schedule">
      <div class="mb-5">
        <label for="taskDescription" class="mb-2.5 block font-medium text-black dark:text-white">Jenis Kegiatan</label>
        <select class="activity w-full rounded-sm border border-stroke bg-white py-3 px-4.5 focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-boxdark dark:focus:border-primary" name="activity_id">
          <option value="0">Pilih kegiatan</option>
          @foreach ($activity as $each_activity)
              <option data-leader="{{ $each_activity->leader }}" value="{{ $each_activity->id }}">{{ $each_activity->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-5 hidden">
        <label for="taskTitle" class="mb-2.5 block font-medium text-black dark:text-white">Pemateri</label>
        <input type="text" disabled name="leader" id="taskTitle" placeholder="Enter task title" class="w-full rounded-sm border border-stroke bg-white py-3 px-4.5 focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-boxdark dark:focus:border-primary">
      </div>
      <div class="mb-5">
        <label for="taskTitle" class="mb-2.5 block font-medium text-black dark:text-white">Tanggal yang dipilih</label>
        <input type="text" name="scheduled_date" readonly id="taskTitle" placeholder="Enter task title" class="w-full rounded-sm border border-stroke bg-white py-3 px-4.5 focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-boxdark dark:focus:border-primary">
      </div>

      <div class="mb-5.5">
          <div class="flex justify-between w-full gap-4">
              <div class="w-1/2">
                  <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                      Waktu mulai
                    </label>
                  <input type="time" name="scheduled_start_time" class="w-full rounded-sm border border-stroke bg-white py-3 px-4.5 focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-boxdark dark:focus:border-primary">
                  @error('start_time')
                      <span class="text-sm text-danger">{{ $message }}</span>
                  @enderror
              </div>
              <div class="w-1/2">
                  <label class="mb-3 block font-medium text-sm text-black dark:text-white">
                      Waktu Berakhir
                    </label>
                  <input type="time" name="scheduled_end_time"  class="w-full rounded-sm border border-stroke bg-white py-3 px-4.5 focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-boxdark dark:focus:border-primary">
                  @error('end')
                      <span class="text-sm text-danger">{{ $message }}</span>
                  @enderror
              </div>
          </div>
      </div>

      <button class="save-modal flex w-full items-center justify-center gap-2 rounded bg-primary py-2.5 px-4.5 font-medium text-white">
        Simpan
      </button>
    </form>
  </div>
</div>
{{-- End modal --}}
{{-- Modal delete confirmation --}}
<div x-transition="" class="hidden modal-confirmation fixed top-0 left-0 z-999999 flex h-full min-h-screen w-full items-center justify-center bg-black/90 px-4 py-5">
  <div class="w-full max-w-142.5 rounded-lg bg-white py-12 px-8 text-center dark:bg-boxdark md:py-15 md:px-17.5">
    <h3 class="pb-2 text-xl font-bold text-black dark:text-white sm:text-2xl">
      Konfirmasi
    </h3>
    <span class="mx-auto mb-6 inline-block h-1 w-22.5 rounded bg-primary"></span>
    <input type="hidden" name="id_schedule">
    <p class="mb-10 font-medium">
      Yakin ingin menghapus jadwal ini ?
    </p>
    <div class="-mx-3 flex flex-wrap gap-y-4">
      <div class="w-full px-3 2xsm:w-1/2">
        <button class="cancel block w-full rounded border border-stroke bg-gray p-3 text-center font-medium text-black transition hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1">
          Tidak
        </button>
      </div>
      <div class="w-full px-3 2xsm:w-1/2">
        <button class="continue block w-full rounded border border-primary bg-primary p-3 text-center font-medium text-white transition hover:bg-opacity-90">
          Ya
        </button>
      </div>
    </div>
  </div>
</div>
{{-- End delete modal confirmation --}}
@endsection
@push('scripts')
<script>
  window.addEventListener('DOMContentLoaded', function () {
    const cells = document.querySelectorAll('td')
    const modal = document.querySelector('.modal')
    const confirmation = document.querySelector('.modal-confirmation')
    const cancelConfirmation = document.querySelector('.cancel')
    const continueConfirmation = document.querySelector('.continue')
    const close = document.querySelector('.close-modal')
    const scheduleId = document.querySelector('input[name="id_schedule"]')
    const save = document.querySelector('.save-modal')
    const activity = document.querySelector('.activity')
    const selectedDate = document.querySelector('input[name="scheduled_date"]')
    // Mendapatkan tanggal sekarang
    var today = new Date();

    // Mengatur bulan dan tahun berdasarkan tanggal sekarang
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();

    // Memanggil fungsi untuk mengisi kalender
    // fillCalendar(currentMonth, currentYear);

    // Fungsi untuk mengisi kalender
    function fillCalendar(month, year, schedules) 
    {
      var calendar = document.getElementById("calendar");

      // Menghapus konten kalender sebelumnya
      calendar.innerHTML = "";

      // Mendapatkan jumlah hari dalam bulan dan tahun yang diberikan
      var totalDays = new Date(year, month + 1, 0).getDate();

      // Mendapatkan hari pertama dalam bulan dan tahun yang diberikan
      var firstDay = new Date(year, month, 1).getDay();

      // Membuat tabel kalender
      var table = document.createElement("table");
      table.classList.add('w-full')

      // Membuat baris untuk nama-nama hari
      var headerRow = document.createElement("tr");
      var weekdays = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

      var heading = document.createElement('thead')
      var body = document.createElement('tbody')
      const headerCellStyle = 'flex h-15 items-center justify-center rounded-tl-sm p-1 text-xs font-semibold sm:text-base xl:p-5'
      const headerRowStyle = 'grid grid-cols-7 rounded-t-sm bg-primary text-white'
      headerRowStyle.split(' ').forEach(style => headerRow.classList.add(style))
      for (var i = 0; i < 7; i++) {
        var headerCell = document.createElement("th");
        headerCellStyle.split(' ').forEach(style => headerCell.classList.add(style))
        headerCell.textContent = weekdays[i];
        headerRow.appendChild(headerCell);
      }
      heading.appendChild(headerRow)

      table.appendChild(heading);

      // Mengisi sel-sel kalender dengan tanggal
      var date = 1;
      for (var i = 0; i < 6; i++) {
        var row = document.createElement("tr");
        'grid grid-cols-7'.split(' ').forEach(item => row.classList.add(item))
        for (var j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            // Sel-sel kosong sebelum tanggal pertama
            var cell = document.createElement("td");
            'ease relative h-20 cursor-pointer border border-stroke p-2 transition duration-500 hover:bg-gray dark:border-strokedark dark:hover:bg-meta-4 md:h-25 md:p-6 xl:h-full'.split(' ').forEach(style => cell.classList.add(style))
            row.appendChild(cell);
          } else if (date > totalDays) {
            // Sel-sel kosong setelah tanggal terakhir
            break;
          } else {
            // Sel-sel dengan tanggal
            var cell = document.createElement("td");
            'ease relative h-20 cursor-pointer border border-stroke p-2 transition duration-500 hover:bg-gray dark:border-strokedark dark:hover:bg-meta-4 md:h-25 md:p-6 xl:h-full'.split(' ').forEach(style => cell.classList.add(style))
            cell.textContent = date;
            let fullDate = `${year}-${month < 10 ? '0' + month : month }-${date < 10 ? '0' + date : date }`
            cell.addEventListener('click', function (e) {
              modal.classList.remove('hidden')
              selectedDate.value = fullDate
            })
            const schedule = schedules[fullDate]
            if (schedule)
            {
              const events = document.querySelectorAll('.event')
              
              
              schedule.forEach(item => {
                const card = document.createElement('div')
                const activityName = document.createElement('span')
                const activityTime = document.createElement('span')
                'time text-sm font-medium text-black dark:text-white'.split(' ').forEach(item => activityTime.classList.add(item))
                'event-name text-sm font-semibold text-black dark:text-white'.split(' ').forEach(item => activityName.classList.add(item)) 
                'event invisible left-2 z-99 mb-1 flex w-[200%] flex-col rounded-sm border-l-[3px] border-primary bg-gray px-3 py-1 text-left opacity-0 group-hover:visible group-hover:opacity-100 dark:bg-meta-4 md:visible md:w-[100%] md:opacity-100'.split(' ').forEach(item => card.classList.add(item))
                card.appendChild(activityName)
                card.appendChild(activityTime)
                activityName.innerText = item.activity.name
                activityTime.innerText = `${item.scheduled_start_time} - ${item.scheduled_start_time}`
                card.addEventListener('click', function (e) {
                  e.stopPropagation();
                  scheduleId.value = item.id
                  confirmation.classList.remove('hidden');
                })
                cell.appendChild(card)
              })
              
            }
            row.appendChild(cell);

            // Menandai sel dengan tanggal sekarang
            if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
              cell.style.fontWeight = "bold";
            }

            date++;
          }
        }

        body.appendChild(row);
      }
      table.appendChild(body)

      calendar.appendChild(table);
    }
    function getUserInput()
    {
      const activityOptions = document.querySelector('select[name="activity_id"]')
      const selectedActivityOptions = activityOptions.options[activityOptions.selectedIndex]
      const scheduleDate = document.querySelector('input[name="scheduled_date"]')
      const scheduleStartTime = document.querySelector('input[name="scheduled_start_time"]')
      const scheduleEndTime = document.querySelector('input[name="scheduled_end_time"]')
      return {
        activity_id: selectedActivityOptions.value,
        scheduled_start_time: scheduleStartTime.value,
        scheduled_end_time: scheduleEndTime.value,
        scheduled_date: scheduleDate.value
      }
    }

    function selectActivity(e) 
    {
      const parentNode = this.parentNode
      const options = e.target.options || e.options
      const index = options.selectedIndex
      const selectedOption = options[index]
      const leader = parentNode.nextElementSibling
      const input = leader.querySelector('input')
      if (selectedOption.value == 0)
      {
        leader.classList.add('hidden');
        return;
      }
      const leaderName = selectedOption.getAttribute('data-leader')
      leader.classList.remove('hidden')
      input.value = leaderName
    }
    function createSchedule(e)
    {
      e.preventDefault();
      let userInput = getUserInput()
      fetch("/api/schedule/create", {
        method: "POST",
        body: JSON.stringify(userInput),
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        }
      })
      .then(result => result.json())
      .then(response => {
        location.reload();
      })
      .catch(error => {
        alert('Yah, Jadwal gagal dibuat, coba ulangi beberapa saat lagi')
      });
    }
    function closeModal()
    {
      if (modal.classList.contains('hidden')) return;
      modal.classList.add('hidden')
    }
    function getSchedule()
    {
      fetch("/api/schedule", {
        method: "GET",
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        }
      })
      .then(result => result.json())
      .then(({data}) => {
        fillCalendar(currentMonth, currentYear, data)
      })
      .catch(error => {
      }); 
    }
    function openSchedule(e) 
    {
      console.log(e)
    }
    function cancel(e) 
    {
      confirmation.classList.add('hidden')
    }
    function next()
    {
      fetch(`/api/schedule/${scheduleId.value}`, {
        method: "DELETE",
        headers: {
          "Content-type": "application/json; charset=UTF-8"
        }
      })
      .then(result => result.json())
      .then(({message}) => {
        location.reload(); 
      })
      .catch(error => {
      }); 
    }
    getSchedule()
    cancelConfirmation.addEventListener('click', cancel)
    continueConfirmation.addEventListener('click', next)
    close.addEventListener('click', closeModal)
    save.addEventListener('click', createSchedule)
    activity.addEventListener('change', selectActivity)
    
  });

</script>
@endpush