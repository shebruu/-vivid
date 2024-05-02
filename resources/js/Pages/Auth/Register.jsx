import { useEffect } from "react";
import GuestLayout from "@/Layouts/GuestLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        firstname: "",
        lastname: "",
        email: "",
        age: "",
        phone: "",
        student: false,
        login: "",
        langue: "",
        password: "",
        password_confirmation: "",
    });

    useEffect(() => {
        return () => {
            reset("password", "password_confirmation");
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route("register"));
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="firstname" value="first Name" />

                    <TextInput
                        id="firstname"
                        type="text"
                        name="firstname"
                        value={data.firstname}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("firstname", e.target.value)}
                        required
                    />

                    <InputError message={errors.firstname} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="lastname" value="Last Name" />

                    <TextInput
                        id="lastname"
                        type="text"
                        name="lastname"
                        value={data.lastname}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("lastname", e.target.value)}
                        required
                    />

                    <InputError message={errors.lastname} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="student" value="Student" />

                    <TextInput
                        id="student"
                        type="checkbox"
                        name="student"
                        checked={data.student}
                        onChange={(e) => setData("student", e.target.checked)}
                    />

                    <InputError message={errors.student} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="age" value="Age" />
                    <TextInput
                        id="age"
                        type="number"
                        name="age"
                        value={data.age}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("age", e.target.value)}
                        required
                    />

                    <InputError message={errors.age} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="phone" value="Phone" />
                    <TextInput
                        id="phone"
                        type="text"
                        name="phone"
                        value={data.phone}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("phone", e.target.value)}
                        required
                    />
                    <InputError message={errors.phone} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="login" value="Login" />
                    <TextInput
                        id="login"
                        type="text"
                        name="login"
                        value={data.login}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("login", e.target.value)}
                        required
                    />
                    <InputError message={errors.login} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="langue" value="Language" />
                    <TextInput
                        id="langue"
                        type="text"
                        name="langue"
                        value={data.langue}
                        className="mt-1 block w-full"
                        onChange={(e) => setData("langue", e.target.value)}
                        required
                    />
                    <InputError message={errors.langue} className="mt-2" />
                </div>


                <div className="mt-4">
        <InputLabel
            htmlFor="password"
            value="Password"
        />

        <TextInput
            id="password"
            type="password"
            name="password"
            value={data.password}
            className="mt-1 block w-full"
            autoComplete="new-password"
            onChange={(e) =>
                setData("password", e.target.value)
            }
            required
        />

        <InputError
            message={errors.password}
            className="mt-2"
        />
    </div>

                <div className="mt-4">
                    <InputLabel
                        htmlFor="password_confirmation"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) =>
                            setData("password_confirmation", e.target.value)
                        }
                        required
                    />

                    <InputError
                        message={errors.password_confirmation}
                        className="mt-2"
                    />
                </div>

                <div className="flex items-center justify-end mt-4">
                    <Link
                        href={route("login")}
                        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Already registered?
                    </Link>

                    <PrimaryButton className="ms-4" disabled={processing}>
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
