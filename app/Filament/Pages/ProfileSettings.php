<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';
    
    protected string $view = 'filament.pages.profile-settings';
    
    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'email' => auth()->user()->email,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema([
                Section::make('Profile Information')
                    ->description('Update your account email address')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(table: 'admins', column: 'email', ignorable: fn () => auth()->user()),
                    ])
                    ->columns(1),

                Section::make('Update Password')
                    ->description('Leave blank if you don\'t want to change your password')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->requiredWith('password')
                            ->revealable(),

                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->rule(Password::default())
                            ->revealable()
                            ->same('password_confirmation')
                            ->validationAttribute('new password'),

                        TextInput::make('password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->requiredWith('password')
                            ->revealable()
                            ->dehydrated(false),
                    ])
                    ->columns(1),
            ]);
    }


    public function updateProfile(): mixed
    {
        $data = $this->form->getState();

        $user = auth()->user();

        // If trying to change password, verify current password
        if (!empty($data['password']) || !empty($data['current_password'])) {
            if (empty($data['current_password'])) {
                Notification::make()
                    ->danger()
                    ->title('Error')
                    ->body('Current password is required to change your password.')
                    ->send();
                return null;
            }

            if (!Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->danger()
                    ->title('Error')
                    ->body('The current password is incorrect.')
                    ->send();
                return null;
            }

            // Update password
            $user->password = Hash::make($data['password']);
        }

        // Update email if changed
        if ($data['email'] !== $user->email) {
            $user->email = $data['email'];
        }

        $user->save();

        // Log out the user for security
        auth()->logout();
        
        // Invalidate the session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        Notification::make()
            ->success()
            ->title('Profile Updated')
            ->body('Your profile has been updated successfully. Please log in again.')
            ->send();
            
        // Redirect to login page
        return redirect()->route('filament.admin.auth.login');
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('updateProfile')
                ->label('Update Profile')
                ->submit('updateProfile')
                ->color('primary'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Profile Settings';
    }

    public function getTitle(): string
    {
        return 'Profile Settings';
    }

    public function getHeading(): string
    {
        return 'Profile Settings';
    }
}
