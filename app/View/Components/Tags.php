<?php

namespace App\View\Components;

use App\Models\Tag;
use Illuminate\View\Component;

class Tags extends Component
{

    public $tags;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->tags = Tag::all();

        $this->tags = [
            'JavaScript',
            'Python',
            'Java',
            'C++',
            'Ruby',
            'Swift',
            'PHP',
            'TypeScript',
            'C#',
            'Go',
            'React',
            'Angular',
            'Vue.js',
            'Express.js',
            'Django',
            'Ruby on Rails',
            'Spring',
            'Laravel',
            'Flask',
            'ASP.NET',
            'Node.js',
            'jQuery',
            'Bootstrap',
            'Tailwind CSS',
            'Sass',
            'Less',
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tags');
    }
}