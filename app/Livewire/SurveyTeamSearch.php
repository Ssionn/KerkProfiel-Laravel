<?php

namespace App\Livewire;

use App\Models\Team;
use Illuminate\Support\Collection;
use Livewire\Component;

class SurveyTeamSearch extends Component
{
    public $search = '';
    public $teamSuggestions = [];

    public function updatedSearchParam(): array|Collection
    {
        if (strlen($this->search) < 1) {
            return $this->teamSuggestions = [];
        }

        return $this->teamSuggestions = Team::where('name', 'LIKE', "%{$this->search}%")
            ->orWhere('description', 'LIKE', "%{$this->search}%")
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.survey-team-search');
    }
}
