<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FixDepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks to allow truncation if needed, or just delete
        // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // \App\Models\Departemen::truncate();
        // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Safer: Update existing or Create new.
        // But user wants to "clean up" others. 
        // Let's delete all first to ensure clean state as requested.
        // Note: This might detach existing Pengurus from Departments. 
        // We might want to keep IDs if possible?
        // Usage of string IDs (dep001) makes it tricky if we change schema.
        // Assuming we can clear them for now since we are refactoring.
        
        $ipnu = [
            'Organisasi', 'Kaderisasi', 'DJSP', 'Desbor', 'Dakwah', 
            'CBP', 'Pers', 'LAN', 'Lekas', 'LKPT', 'BSRC', 'BSCC'
        ];
        
        $ippnu = [
            'Organisasi', 'Kaderisasi', 'DJSMPP', 'Desbor', 'Dakwah', 
            'Jarkom KPP', 'LKP', 'LKDC', 'LEK'
        ];
        
        // Let's loop and update/create.
        // We need unique IDs.
        
        $counter = 1;
        
        foreach ($ipnu as $nama) {
            $id = 'dep' . str_pad($counter++, 3, '0', STR_PAD_LEFT);
            // Check if exists by name to preserve ID? 
            // Or just overwrite.
            // Let's try to match by name to minimize disruption, else create new.
            $exist = \App\Models\Departemen::where('nama_departemen', $nama)->first();
            
            if ($exist) {
                // If exists, just ensure category is IPNU (or update if it was generic)
                // If it's Organisasi, it might be both. 
                // But user wanted separate structures.
                // If we have "Organisasi" already, is it IPNU or IPPNU?
                // We should probably create distinct ones: "Departemen Organisasi (IPNU)" vs "Departemen Organisasi (IPPNU)"?
                // The prompt lists them simply as "Organisasi".
                // In the UI we will filter "Where Kategori = IPNU".
                // So if "Organisasi" is shared, it will appear in both?
                // No, user said "sendiri sendiri". 
                // So we likely need 2 rows: Organisasi (IPNU) and Organisasi (IPPNU).
                // But names might duplicate. 
                // Let's append category to name or allow duplicate names?
                // Standard approach: allow duplicate names, different IDs/Category.
            } 
            
            // Create specific row for IPNU
             \App\Models\Departemen::updateOrCreate(
                ['nama_departemen' => $nama, 'kategori' => 'IPNU'],
                ['id' => 'ipnu_' . \Illuminate\Support\Str::slug($nama)] // Custom ID to separate
            );
        }

        foreach ($ippnu as $nama) {
             \App\Models\Departemen::updateOrCreate(
                ['nama_departemen' => $nama, 'kategori' => 'IPPNU'],
                ['id' => 'ippnu_' . \Illuminate\Support\Str::slug($nama)]
            );
        }
        
        // Clean up old ones?
        // Be careful not to break FKs. Old IDs were 'depXXX'.
        // If we want to fully switch, we should update Pengurus FKs too?
        // That's complex.
        
        // Alternative: Just update the existing 'depXXX' to have categories?
        // Current: dep007 => Organisasi.
        // If we set dep007 to 'IPNU', then IPPNU loses it.
        // So we MUST create a new one for IPPNU.
        // Let's migrate 'Organisasi' (dep007) to 'IPNU'.
        // And create a NEW 'Organisasi' for 'IPPNU'.
        
        // EXISTING MAPPING Strategy
        $mapIpnu = [
            'Organisasi' => 'Organisasi', 
            'Kaderisasi' => 'Kaderisasi',
            'DJSP' => 'DJSP',
            'Desbor' => 'Desbor',
            'Dakwah' => 'Dakwah',
            'CBP' => 'CBP',
            'Pers' => 'Pers', // Was PERS
            'LAN' => 'LAN',
            'Lekas' => 'LEKAS', // Was LEKAS
            'LKPT' => 'LKPT',
            'BSRC' => 'BSRC',
            'BSCC' => 'BSCC'
        ];
        
        // Update existing to IPNU first
        foreach($mapIpnu as $new => $old) {
             \App\Models\Departemen::where('nama_departemen', 'LIKE', $old)
                ->update(['nama_departemen' => $new, 'kategori' => 'IPNU']);
        }
        
        // Create IPPNU specifics
        foreach ($ippnu as $nama) {
            // Check if exists as IPNU?
            $check = \App\Models\Departemen::where('nama_departemen', $nama)->where('kategori', 'IPNU')->first();
            
            if ($check) {
                // We have an IPNU one. We need an IPPNU clone.
                 \App\Models\Departemen::create([
                     'id' => 'ippnu_' . \Illuminate\Support\Str::slug($nama) . '_' . rand(100,999),
                     'nama_departemen' => $nama,
                     'kategori' => 'IPPNU'
                 ]);
            } else {
                // Check if it exists at all (maybe unique to IPPNU like Jarkom)
                 $checkAny = \App\Models\Departemen::where('nama_departemen', $nama)->first();
                 if ($checkAny && $checkAny->kategori === 'Joint') {
                     // It's unique to IPPNU, update it
                     $checkAny->update(['kategori' => 'IPPNU']);
                 } elseif (!$checkAny) {
                     // Create new
                     \App\Models\Departemen::create([
                         'id' => 'ippnu_' . \Illuminate\Support\Str::slug($nama) . '_' . rand(100,999),
                         'nama_departemen' => $nama,
                         'kategori' => 'IPPNU'
                     ]);
                 }
            }
        }
        
        // Remove "KSB" and "Lainnya"
        \App\Models\Departemen::whereIn('nama_departemen', ['KSB', 'Lainnya.'])->delete();
        
    }
}
