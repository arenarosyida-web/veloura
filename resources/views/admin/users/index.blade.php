<x-layouts.admin title="Management User">

<div class="space-y-5 font-jost">

  {{-- ── Header ── --}}
  <div class="flex items-end justify-between" data-aos="fade-down" data-aos-duration="400">
    <div>
      <p class="text-[10px] font-medium uppercase tracking-[3px] text-gold-500 mb-1">Admin</p>
      <h1 class="font-cormorant text-3xl font-normal text-brand-900">Management User</h1>
    </div>
  </div>

  {{-- ── Divider ── --}}
  <div class="flex items-center gap-3" data-aos="fade-right" data-aos-duration="300">
    <div class="h-px flex-1 bg-brand-200"></div>
    <div class="h-1.5 w-1.5 rotate-45 bg-gold-400"></div>
    <div class="h-px w-8 bg-brand-200"></div>
  </div>

  {{-- Flash --}}
  @if(session('success'))
  <div class="border border-brand-200 bg-brand-50 px-4 py-3
              text-[11px] font-medium uppercase tracking-[2px] text-brand-700"
       data-aos="fade-down">
    {{ session('success') }}
  </div>
  @endif
  @if(session('error'))
  <div class="border border-red-200 bg-red-50 px-4 py-3
              text-[11px] font-medium uppercase tracking-[2px] text-red-600"
       data-aos="fade-down">
    {{ session('error') }}
  </div>
  @endif

  {{-- ── MOBILE: Card List ── --}}
  <div class="space-y-3 md:hidden" data-aos="fade-up" data-aos-duration="500">
    @forelse($users as $user)
    <div class="border border-brand-200 bg-cream px-4 py-4 space-y-3">

      {{-- Row 1: Avatar + Nama + Role --}}
      <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
          <div class="flex h-9 w-9 shrink-0 items-center justify-center border border-brand-200 bg-brand-50
                      text-[11px] font-medium text-brand-700">
            {{ strtoupper(substr($user->name, 0, 1)) }}
          </div>
          <div class="min-w-0">
            <p class="text-[12px] font-medium text-brand-900 truncate">{{ $user->name }}</p>
            <div class="flex items-center gap-1.5 mt-0.5">
              <span class="h-1.5 w-1.5 rotate-45
                {{ $user->role === 'admin' ? 'bg-gold-400' : 'bg-green-500' }}"></span>
              <span class="text-[10px] font-light capitalize
                {{ $user->role === 'admin' ? 'text-gold-500' : 'text-brand-600' }}">
                {{ ucfirst($user->role) }}
              </span>
            </div>
          </div>
        </div>
        {{-- Aksi --}}
        @if($user->id !== auth()->id())
          <button type="button"
                  onclick="openDeleteModal('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                  class="shrink-0 border border-red-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-red-600 font-semibold
                         transition-colors hover:border-red-400 hover:bg-red-50 hover:text-red-600">
            Hapus
          </button>
        @else
          <span class="text-[10px] font-light italic text-brand-300 shrink-0">Akun kamu</span>
        @endif
      </div>

      {{-- Divider --}}
      <div class="h-px bg-brand-100"></div>

      {{-- Row 2: Email --}}
      <div>
        <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Email</p>
        <p class="text-[11px] font-light text-brand-600 truncate">{{ $user->email }}</p>
      </div>

      {{-- Row 3: Pesanan + Bergabung --}}
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Pesanan</p>
          <p class="text-[12px] font-medium text-brand-800">{{ $user->orders_count }} pesanan</p>
        </div>
        <div class="text-right">
          <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-600 mb-0.5">Bergabung</p>
          <p class="text-[11px] font-light text-brand-600">{{ $user->created_at->format('d M Y') }}</p>
        </div>
      </div>

    </div>
    @empty
    <div class="border border-brand-200 bg-cream px-5 py-16 text-center">
      <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-brand-200 bg-brand-50">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
      </div>
      <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada user</p>
    </div>
    @endforelse
  </div>

  {{-- ── DESKTOP: Table ── --}}
  <div class="hidden overflow-hidden border border-brand-200 bg-cream md:block"
       data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
    <table class="w-full">
      <thead>
        <tr class="border-b border-brand-200 bg-brand-50/60">
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Nama</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Email</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Role</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Pesanan</th>
          <th class="px-5 py-3 text-left text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Bergabung</th>
          <th class="px-5 py-3 text-right text-[10px] font-medium uppercase tracking-[2px] text-brand-800">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr class="border-b border-brand-100 transition-colors last:border-0 hover:bg-brand-50/40">
          <td class="px-5 py-4">
            <div class="flex items-center gap-3">
              <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-brand-200 bg-brand-50
                          text-[11px] font-medium text-brand-700">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              <span class="text-[12px] font-medium text-brand-900">{{ $user->name }}</span>
            </div>
          </td>
          <td class="px-5 py-4">
            <span class="text-[11px] font-light text-brand-600">{{ $user->email }}</span>
          </td>
          <td class="px-5 py-4">
            <div class="flex items-center gap-1.5">
              <span class="h-1.5 w-1.5 rotate-45
                {{ $user->role === 'admin' ? 'bg-gold-400' : 'bg-green-500' }}"></span>
              <span class="text-[11px] font-light capitalize
                {{ $user->role === 'admin' ? 'text-gold-500' : 'text-brand-600' }}">
                {{ ucfirst($user->role) }}
              </span>
            </div>
          </td>
          <td class="px-5 py-4">
            <span class="text-[12px] font-medium text-brand-800">{{ $user->orders_count }} pesanan</span>
          </td>
          <td class="px-5 py-4">
            <span class="text-[11px] font-light text-brand-600">{{ $user->created_at->format('d M Y') }}</span>
          </td>
          <td class="px-5 py-4 text-right">
            @if($user->id !== auth()->id())
              <button type="button"
                      onclick="openDeleteModal('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                      class="border border-red-200 px-3 py-1.5 text-[10px] font-medium uppercase tracking-[1px] text-red-600 font-semibold
                             transition-colors hover:border-red-400 hover:bg-red-50 hover:text-red-600">
                Hapus
              </button>
            @else
              <span class="text-[10px] font-light italic text-brand-300">Akun kamu</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-5 py-16 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center border border-brand-200 bg-brand-50">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A8D5B5" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
              </svg>
            </div>
            <p class="font-cormorant text-xl font-normal text-brand-800">Belum ada user</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Count + Pagination --}}
  @if($users->count() > 0)
  <div class="flex items-center justify-between" data-aos="fade-up" data-aos-delay="200">
    <p class="text-[10px] font-medium uppercase tracking-[2px] text-brand-700">
      {{ $users->total() }} user terdaftar
    </p>
    @if($users->hasPages())
      <div class="text-[11px] font-medium text-brand-700">
        {{ $users->links() }}
      </div>
    @endif
  </div>
  @endif

</div>

{{-- Hidden delete forms --}}
@foreach($users as $user)
  @if($user->id !== auth()->id())
  <form id="delete-form-{{ $user->id }}"
        action="{{ route('admin.users.destroy', $user->id) }}"
        method="POST" class="hidden">
    @csrf
    @method('DELETE')
  </form>
  @endif
@endforeach

{{-- ── Delete Confirmation Modal ── --}}
<div id="delete-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-brand-950/40 backdrop-blur-sm">
  <div class="mx-4 w-full max-w-sm border border-brand-200 bg-cream p-6 shadow-xl font-jost">
    <div class="mb-4 flex items-center gap-3">
      <div class="h-px w-8 bg-brand-200"></div>
      <div class="h-2 w-2 rotate-45 bg-red-600"></div>
      <div class="h-px flex-1 bg-brand-200"></div>
    </div>
    <p class="text-[10px] font-medium uppercase tracking-[3px] text-red-600 font-semibold mb-1">Tindakan Permanen</p>
    <h3 class="font-cormorant text-2xl font-normal text-brand-900 mb-2">Hapus User Ini?</h3>
    <p class="text-[13px] font-medium text-brand-800 leading-relaxed mb-1">
      Anda akan menghapus akun
      <span id="modal-user-name" class="font-medium text-brand-900"></span>.
    </p>
    <p class="text-[11px] font-light text-red-600 font-semibold mb-6">
      Semua data pesanannya juga akan ikut terhapus dan tidak dapat dipulihkan.
    </p>
    <div class="flex items-center gap-3">
      <button id="btn-confirm-delete"
              class="bg-red-600 px-6 py-2.5 text-[11px] font-medium uppercase
                     tracking-[2px] text-white transition-colors hover:bg-red-700">
        Ya, Hapus
      </button>
      <button onclick="closeDeleteModal()"
              class="border border-brand-200 px-6 py-2.5 text-[11px] font-medium uppercase
                     tracking-[2px] text-brand-700 transition-colors
                     hover:border-brand-800 hover:text-brand-900">
        Batal
      </button>
    </div>
  </div>
</div>

<script>
  let targetFormId = null;

  function openDeleteModal(userId, userName) {
    targetFormId = 'delete-form-' + userId;
    document.getElementById('modal-user-name').textContent = userName;
    const modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    targetFormId = null;
  }

  document.getElementById('btn-confirm-delete').addEventListener('click', function () {
    if (targetFormId) document.getElementById(targetFormId).submit();
  });

  document.getElementById('delete-modal').addEventListener('click', function (e) {
    if (e.target === this) closeDeleteModal();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDeleteModal();
  });
</script>

</x-layouts.admin>