@extends('partials.layouts.main')

@section('documentTitle')
  Thông tin cá nhân
@endsection

@section('content')
  <!-- Modal -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <form action="{{ route('users.updatePassword', ['id' => $currentUser['id'] ]) }}" method="POST" id="changePasswordForm">
          @csrf

          <div class="modal-header">
            <h5 class="modal-title font-weight-bold">Đổi mật khẩu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
  
          <div class="modal-body">
  
            {{-- <div id="changePasswordModalErrorMsg" class="bg-danger form-msg">
              
            </div>
  
            <input type="text" id="userId" name="id" value="<%= currentUser.id %>" readonly hidden> --}}
  
            <div class="form-group">
              <label for="oldPassword" class="font-weight-bold">Mật khẩu cũ</label>
              <input type="password" id="oldPassword" class="form-control form-control-sm font-weight-bold" name="oldPassword">
              <div class="invalid-feedback oldPassword-error"></div>
            </div>
  
            <div class="form-group">
              <label for="newPassword" class="font-weight-bold">Mật khẩu mới</label>
              <input type="password" id="newPassword" class="form-control form-control-sm font-weight-bold" name="newPassword">
              <div class="invalid-feedback newPassword-error"></div>
            </div>
  
            <div class="form-group">
              <label for="newPassword2" class="font-weight-bold">Nhập lại mật khẩu mới</label>
              <input type="password" id="newPassword2" class="form-control form-control-sm font-weight-bold" name="newPassword_confirmation">
              <div class="invalid-feedback newPassword_confirmation-error"></div>
            </div>
  
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
            <button id="changePasswordSubmit" type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
          </div>

        </form>

      </div>
    </div>
  </div>

  {{-- User info --}}
  <div class="card">
    <div class="card-body">
      <div class="card-title">Thông tin cá nhân</div>

      <a data-toggle="modal" data-target="#changePasswordModal" class="btn btn-primary btn-sm btn-icon-text mb-3"> <i class="fa-solid fa-key btn-icon-prepend"></i> Đổi mật khẩu</a>

      @if ($currentUser['role'] == 3)
        <div class="row">

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Mã học sinh</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->id }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">họ</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->first_name }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Tên</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->last_name }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Giới tính</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->gender ? 'Nam' : 'Nữ' }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Ngày sinh</label>
            <input type="text" class="form-control font-weight-bold" value="{{ date_format(date_create($user->dob), 'd-m-Y') }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Địa chỉ</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->address }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Email</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->email }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Số điện thoại</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->parent_phone }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Chức vụ</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->role->name }}" readonly>
          </div>


        </div>
      @else
        <div class="row">

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Mã nhân viên</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->id }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">họ</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->first_name }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Tên</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->last_name }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Giới tính</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->gender ? 'Nam' : 'Nữ' }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Ngày sinh</label>
            <input type="text" class="form-control font-weight-bold" value="{{ date_format(date_create($user->dob), 'd-m-Y') }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Địa chỉ</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->address }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Email</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->email }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Số điện thoại</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->phone }}" readonly>
          </div>

          <div class="col-sm-12 col-md-4 mb-3">
            <label for="">Chức vụ</label>
            <input type="text" class="form-control font-weight-bold" value="{{ $user->role->name }}" readonly>
          </div>


        </div>
      @endif
      
    </div>
  </div>
@endsection

@push('js')
  <script>
    const changePasswordForm = document.querySelector('#changePasswordForm')

    changePasswordForm.addEventListener('submit', e => {
      e.preventDefault()

      const data = {
        '_token': '{{ csrf_token() }}',
        'oldPassword': document.querySelector('#changePasswordForm input[name=oldPassword]').value,
        'newPassword': document.querySelector('#changePasswordForm input[name=newPassword]').value,
        'newPassword_confirmation': document.querySelector('#changePasswordForm input[name=newPassword_confirmation]').value
      }

      fetch('{{ route('users.updatePassword', ['id' => $currentUser['id'] ]) }}', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
          'Accept': 'application/json',
          'Content-type': 'application/json',
        },
      })
      .then(response => response.json())
      .then(data => {
        if(!data.status) {
          for (const message in data.messages) {
            document.querySelector(`#changePasswordForm input[name=${message}]`).style.border =  '1px solid #dc3545';
            document.querySelector(`#changePasswordForm .${message}-error`).style.display = 'block';
            document.querySelector(`#changePasswordForm .${message}-error`).innerHTML = data.messages[message];
          }
        }
        else {
          const wrapper = document.querySelector('.container-scroller');
          document.querySelector('#changePasswordModal').classList.remove('show');
          document.querySelector('body').classList.remove('modal-open');
          document.querySelector('.modal-backdrop').style.display = 'none';

          let notification = document.createElement('div');
          notification.classList.add('notification', 'bg-success');
          notification.style.left = '10px';
          notification.textContent = data.message; 

          wrapper.append(notification);

          setTimeout(() => {
            window.location.replace(`{{ route('logout') }}`);
          }, 1500);
        }
      });

    })

  </script>
@endpush