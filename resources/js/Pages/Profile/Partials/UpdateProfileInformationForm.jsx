import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';

export default function UpdateProfileInformation({ mustVerifyEmail, status, className = '' }) {
    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        firstname: user.firstname ?? '',
        lastname: user.lastname ?? '',
        email: user.email,
        age: user.age ?? '',
        phone: user.phone ?? '',
        student: user.student ?? false,
        login: user.login ?? '',
        langue: user.langue ?? '',
    });
    const submit = (e) => {
        e.preventDefault();

        patch(route('profile.update'));
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Profile Information</h2>

                <p className="mt-1 text-sm text-gray-600">
                    Update your account's profile information and email address.
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
            <div>
                    <InputLabel htmlFor="firstname" value="First Name" />
                    <TextInput
                        id="firstname"
                        className="mt-1 block w-full"
                        value={data.firstname}
                        onChange={(e) => setData('firstname', e.target.value)}
                        required
                        autoComplete="given-name"
                    />
                    <InputError className="mt-2" message={errors.firstname} />
                </div>


                <div>
                    <InputLabel htmlFor="lastname" value="Last Name" />
                    <TextInput
                        id="lastname"
                        className="mt-1 block w-full"
                        value={data.lastname}
                        onChange={(e) => setData('lastname', e.target.value)}
                        autoComplete="family-name"
                    />
                    <InputError className="mt-2" message={errors.lastname} />
                </div>

                <div>
                    <InputLabel htmlFor="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        className="mt-1 block w-full"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        required
                        autoComplete="username"
                    />

                    <InputError className="mt-2" message={errors.email} />
                </div>

                <div>
                    <InputLabel htmlFor="age" value="Age" />
                    <TextInput
                        id="age"
                        type="number"
                        className="mt-1 block w-full"
                        value={data.age}
                        onChange={(e) => setData('age', e.target.value)}
                        autoComplete="age"
                    />
                    <InputError className="mt-2" message={errors.age} />
                </div>

                <div>
                    <InputLabel htmlFor="phone" value="Phone" />
                    <TextInput
                        id="phone"
                        type="tel"
                        className="mt-1 block w-full"
                        value={data.phone}
                        onChange={(e) => setData('phone', e.target.value)}
                        autoComplete="tel"
                    />
                    <InputError className="mt-2" message={errors.phone} />
                </div>

                <div>
                    <InputLabel htmlFor="student" value="Are you a student?" />
                    <input
                        id="student"
                        type="checkbox"
                        className="mt-1"
                        checked={data.student}
                        onChange={(e) => setData('student', e.target.checked)}
                    />
                    <InputError className="mt-2" message={errors.student} />
                </div>

                <div>
                    <InputLabel htmlFor="langue" value="Language" />
                    <TextInput
                        id="langue"
                        className="mt-1 block w-full"
                        value={data.langue}
                        onChange={(e) => setData('langue', e.target.value)}
                    />
                    <InputError className="mt-2" message={errors.langue} />
                </div>

                {mustVerifyEmail && user.email_verified_at === null && (
                    <div>
                        <p className="text-sm mt-2 text-gray-800">
                            Your email address is unverified.
                            <Link
                                href={route('verification.send')}
                                method="post"
                                as="button"
                                className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Click here to re-send the verification email.
                            </Link>
                        </p>

                        {status === 'verification-link-sent' && (
                            <div className="mt-2 font-medium text-sm text-green-600">
                                A new verification link has been sent to your email address.
                            </div>
                        )}
                    </div>
                )}

                
                {/* Submit Button */}

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600">Saved.</p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
