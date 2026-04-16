<x-layouts.app>

{{-- Profile sections --}}
<section class="bg-cream px-6 py-16 font-jost lg:px-16">
  <div class="mx-auto max-w-6xl space-y-10">

    {{-- Update Profile Information --}}
    <div class="border-[0.5px] border-[#A8D5B5]/40 bg-[#FDFCFA] p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100" data-aos-duration="650">
      @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Update Password --}}
    <div class="border-[0.5px] border-[#A8D5B5]/40 bg-[#FDFCFA] p-6 sm:p-8" data-aos="fade-up" data-aos-delay="150" data-aos-duration="650">
      @include('profile.partials.update-password-form')
    </div>

    {{-- Delete Account --}}
    <div class="border-[0.5px] border-red-200/60 bg-[#FDFCFA] p-6 sm:p-8" data-aos="fade-up" data-aos-delay="200" data-aos-duration="650">
      @include('profile.partials.delete-user-form')
    </div>

  </div>
</section>

</x-layouts.app>
