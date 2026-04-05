<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        return view('admin.programs.index', [
            'programs' => Program::query()->paginate(15),
            'pendingProgramRequests' => OrderItem::query()
                ->with(['order.user', 'program'])
                ->whereNotNull('program_id')
                ->whereHas('order', fn ($q) => $q->where('status', 'pending')->whereNotNull('user_id'))
                ->latest()
                ->take(40)
                ->get(),
        ]);
    }

    public function assignCartRequest(Request $request, OrderItem $orderItem): RedirectResponse
    {
        $validated = $request->validate([
            'pdf_link' => ['nullable', 'url', 'max:2048'],
        ]);

        $pdfLink = trim((string) ($validated['pdf_link'] ?? ''));
        $pdfLink = $pdfLink !== '' ? $pdfLink : null;

        $orderItem->load(['order.items', 'order.user', 'program']);

        $order = $orderItem->order;
        $user = $order?->user;
        $program = $orderItem->program;

        if (! $order || ! $user || ! $program) {
            return redirect()->route('admin.programs.index')->with('error', 'Demande invalide : client/programme introuvable.');
        }

        DB::transaction(function () use ($user, $program, $order, $pdfLink): void {
            if (! $user->subscribedPrograms()->where('programs.id', $program->id)->exists()) {
                $user->subscribedPrograms()->attach($program->id, [
                    'order_id' => $order->id,
                    'pdf_link' => $pdfLink,
                ]);
            } elseif ($pdfLink) {
                $user->subscribedPrograms()->updateExistingPivot($program->id, [
                    'pdf_link' => $pdfLink,
                ]);
            }

            $allProgramItemsAreAssigned = $order->items
                ->whereNotNull('program_id')
                ->every(fn ($item) => $user->subscribedPrograms()->where('programs.id', $item->program_id)->exists());

            if ($allProgramItemsAreAssigned && $order->status === 'pending') {
                $order->update(['status' => 'approved']);
            }
        });

        return redirect()->route('admin.programs.index')->with('status', 'Programme ajouté au client avec succès.');
    }

    public function create(): View
    {
        return view('admin.programs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedProgramFields($request);
        Program::query()->create($data);

        return redirect()->route('admin.programs.index');
    }

    public function show(Program $program): View
    {
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $data = $this->validatedProgramFields($request, $program);
        $program->update($data);

        return redirect()->route('admin.programs.index');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()->route('admin.programs.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedProgramFields(Request $request, ?Program $program = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('programs', 'slug')->ignore($program?->id),
            ],
            'description' => ['nullable', 'string'],
            'video_url' => ['sometimes', 'nullable', 'string', 'max:2048', 'url'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['sometimes', 'nullable', 'string', 'max:2048', 'url'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        $slug = trim((string) ($data['slug'] ?? ''));
        $data['slug'] = $slug !== '' ? Str::slug($slug) : Str::slug($data['title']);
        $data['is_visible'] = $request->boolean('is_visible', true);

        if (array_key_exists('video_url', $data)) {
            $v = trim((string) ($data['video_url'] ?? ''));
            $data['video_url'] = $v !== '' ? $v : null;
        }

        $data['image'] = $this->resolveProgramImage($request, $program);
        unset($data['image_file'], $data['image_url']);

        return $data;
    }

    private function resolveProgramImage(Request $request, ?Program $program = null): ?string
    {
        if ($request->hasFile('image_file')) {
            return $request->file('image_file')->store('programs', 'public');
        }

        $url = trim((string) $request->input('image_url', ''));
        if ($url !== '') {
            return $url;
        }

        return $program?->image;
    }
}
