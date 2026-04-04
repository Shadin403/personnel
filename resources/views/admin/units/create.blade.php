@extends('layouts.admin')

@section('title', 'Establish Unit')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.units.index') }}" class="inline-flex items-center gap-2 text-[11px] font-bold text-slate-400 hover:text-military-primary transition-colors tracking-widest uppercase mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Cancel Mission
        </a>
        <h2 class="text-2xl font-black text-military-primary tracking-tight uppercase">Establish Organizational Unit</h2>
        <p class="text-[11px] font-bold text-military-accent uppercase tracking-widest mt-1 opacity-70">
            Define New Command Node
        </p>
    </div>

    <form action="{{ route('admin.units.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="classic-card">
            <div class="classic-card-header">
                <span class="text-[11px] font-bold uppercase tracking-widest">Unit Configuration</span>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Unit Name -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Unit Designation</label>
                        <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. 1st Platoon"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-[13px] font-bold focus:ring-2 focus:ring-military-primary focus:border-military-primary outline-none transition-all placeholder:text-slate-400 placeholder:font-medium">
                        @error('name') <p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Unit Type -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Node Type</label>
                        <select name="type" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-[13px] font-bold focus:ring-2 focus:ring-military-primary outline-none transition-all">
                            <option value="company" {{ old('type') == 'company' ? 'selected' : '' }}>Company (Coy)</option>
                            <option value="platoon" {{ old('type') == 'platoon' ? 'selected' : '' }}>Platoon (PL)</option>
                            <option value="section" {{ old('type') == 'section' ? 'selected' : '' }}>Section (SEC)</option>
                            <option value="battalion" {{ old('type') == 'battalion' ? 'selected' : '' }}>Battalion</option>
                        </select>
                        @error('type') <p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Parent Unit -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Superior Command</label>
                        <select name="parent_id"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-[13px] font-bold focus:ring-2 focus:ring-military-primary outline-none transition-all">
                            <option value="">-- No Direct Superior --</option>
                            @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                [{{ strtoupper($parent->type) }}] {{ $parent->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('parent_id') <p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Appointment -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Commanding Appointment</label>
                        <textarea id="appointment_editor" name="appointment" class="w-full">{{ old('appointment') }}</textarea>
                        @error('appointment') <p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Active Status -->
                <div class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200">
                    <input type="checkbox" name="is_active" id="is_active" checked value="1"
                        class="w-4 h-4 text-military-primary border-slate-300 focus:ring-military-primary">
                    <label for="is_active" class="text-[11px] font-bold uppercase tracking-widest text-military-primary">Active Operational Status</label>
                </div>
            </div>
            
            <div class="px-8 py-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                <button type="submit" class="btn-military shadow-xl">
                    Confirm Establishment
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#appointment_editor'), {
            toolbar: ['bold', 'italic', 'bulletedList', 'numberedList', 'undo', 'redo'],
            placeholder: 'e.g. COY COMD MAJ WASIQUEL ISLAM, PSC'
        })
        .catch(error => {
            console.error(error);
        });
</script>
<style>
    .ck-editor__editable {
        min-height: 150px;
        background-color: #f8fafc !important;
        font-size: 13px !important;
        font-weight: 700 !important;
    }
    .ck-toolbar {
        border-color: #e2e8f0 !important;
        background: #f1f5f9 !important;
    }
</style>
@endsection
