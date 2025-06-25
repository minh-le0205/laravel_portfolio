<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
  public function edit()
  {
    $about = AboutSetting::getInstance();
    return view('admin.about.edit', compact('about'));
  }

  public function update(Request $request)
  {
    $request->validate([
      'biography' => 'required|string',
      'skills' => 'required|array',
      'skills.*' => 'required|string',
      'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $about = AboutSetting::getInstance();

    // Handle resume upload
    if ($request->hasFile('resume')) {
      // Delete old resume if exists
      if ($about->resume_path) {
        Storage::delete($about->resume_path);
      }

      $path = $request->file('resume')->store('resumes', 'public');
      $about->resume_path = $path;
    }

    $about->biography = $request->biography;
    $about->skills = $request->skills;
    $about->save();

    return redirect()->route('admin.about.edit')->with('success', 'About page updated successfully.');
  }

  public function deleteResume()
  {
    $about = AboutSetting::getInstance();

    if ($about->resume_path) {
      Storage::delete($about->resume_path);
      $about->resume_path = null;
      $about->save();
    }

    return redirect()->route('admin.about.edit')->with('success', 'Resume deleted successfully.');
  }
}
