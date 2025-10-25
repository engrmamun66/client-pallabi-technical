<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\AboutSection;
use App\Models\Admission;
use App\Models\Blog;
use App\Models\Course;
use App\Models\DirectorSection;
use App\Models\Gallery;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.pages.contact');
    }
    public function noticePage()
    {
        $notices = Notice::where('status','notice')->orderBy('id','desc')->get();
        return view('frontend.pages.notice',compact('notices'));
    }
    public function eventPage()
    {
        $events = Notice::where('status','events')->orderBy('id','desc')->get();
        return view('frontend.pages.event',compact('events'));
    }

    public function submit(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Mail::to('pallabitechnical@gmail.com')->send(new ContactFormMail($validatedData));

        return redirect()->back()->with('success', 'Thank you for your message. We\'ll get back to you soon!');
    }
    public function galleryPage()
    {
        $galleries = Gallery::orderBy('id','desc')->get();
        return view('frontend.pages.gallery',compact('galleries'));
    }
    public function directorPage()
    {
        $latestDirectorSection = DirectorSection::latest()->first();
        return view('frontend.pages.director',compact('latestDirectorSection'));
    }

    public function aboutPage()
    {
        $latestAboutSection = AboutSection::latest()->first();
        return view('frontend.pages.about',compact('latestAboutSection'));
    }

    public function coursePage($id)
    {
        $course = Course::find($id);
        return view('frontend.pages.course',compact('course'));
    }
    public function admissionPage()
    {
        $latestAdmission = Admission::latest()->first();
        return view('frontend.pages.admission',compact('latestAdmission'));
    }

    public function blogDetailsPage($slug)
    {
        $blog = Blog::where('slug',$slug)->first();
        $relatedBlogs = Blog::where('id','!=',$blog->id)->get();
        return view('frontend.pages.blog-details',compact('blog','relatedBlogs'));
    }

}
