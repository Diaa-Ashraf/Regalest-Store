@extends('layouts.admin')

@section('title', __('تعديل بيانات المشرف'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-[#18181B]">{{ __('تعديل بيانات المشرف') }}</h2>
            <p class="text-sm text-[#71717A] mt-0.5">{{ __('تحديث البيانات الشخصية وصلاحيات الحساب') }}: <span class="font-semibold text-[#18181B]">{{ $user->name }}</span></p>
        </div>
        <a href="{{ route('users.index') }}" class="px-4 py-2 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
            {{ __('العودة للقائمة') }}
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-[#EADBCC] rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('اسم المشرف') }} <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('name') border-rose-500 @enderror" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('البريد الإلكتروني') }} <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('email') border-rose-500 @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('كلمة المرور الجديدة') }}</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('password') border-rose-500 @enderror" 
                           placeholder="{{ __('اتركها فارغة إذا لم ترغب في التغيير') }}">
                    @error('password')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-[#18181B] mb-2">{{ __('الدور / الصلاحية') }} <span class="text-rose-500">*</span></label>
                    <select id="role" name="role" 
                            class="w-full px-4 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2]/40 text-[#18181B] focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059] focus:outline-none text-sm transition-all @error('role') border-rose-500 @enderror" required>
                        <option value="">{{ __('اختر الصلاحية المناسبة') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ (method_exists($user, 'hasRole') && $user->hasRole($role->name)) ? 'selected' : '' }}>
                                {{ $role->display_name ?? $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-[#EADBCC] flex items-center justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl border border-[#EADBCC] bg-[#F8F6F2] hover:bg-[#EDE8DC] text-[#18181B] text-sm font-semibold transition-colors">
                    {{ __('إلغاء') }}
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#18181B] hover:bg-[#27272A] text-white text-sm font-semibold shadow-sm transition-all">
                    {{ __('تحديث بيانات المشرف') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection