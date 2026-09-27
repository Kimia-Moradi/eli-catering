<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {--name=} {--email=} {--password=}';

    protected $description = 'Create a new admin login (e.g. for the restaurant owner, separate from the developer/seeded account)';

    public function handle(): int
    {
        $name = $this->option('name') ?: $this->ask('نام');
        $email = $this->option('email') ?: $this->ask('ایمیل');
        $password = $this->option('password') ?: $this->secret('رمز عبور (حداقل ۸ کاراکتر) — Enter دستی وارد کنید، در ترمینال نمایش داده نمی‌شود');

        $validator = Validator::make(compact('name', 'email', 'password'), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password, // hashed automatically via the User model's cast
            'role' => 'admin',
        ]);

        $this->info("کاربر مدیر جدید با ایمیل {$email} ساخته شد. حالا می‌توانید این ایمیل و رمز را در اختیار او بگذارید.");
        $this->comment('توصیه می‌شود بلافاصله بعد از اولین ورود، رمز عبور را از صفحه‌ی «تغییر رمز عبور» در پنل تغییر دهد.');

        return self::SUCCESS;
    }
}
