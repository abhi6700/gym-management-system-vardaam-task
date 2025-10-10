import AppLayout from '@/layouts/app-layout';
import password from '@/routes/password';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gym Members',
        href: '/gym_members',
    },
];

export default function CreateGymMembers({error}) {
    const {data, setData, errors, post, reset, processing} = useForm({
        name: '',
        email: '',
        dob: '',
    })

    function submit(e) {
        e.preventDefault();
        post('/tenant/gym_members');
    }
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Gym" />
            <div className="container ms-auto p-4">
                <div className='flex justify-between items-center mb-4'>
                    <h1 className='text-2xl font-bold'>Add Gym member</h1>
                    <Link href="/tenant/gym_members" className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>
                        Back
                    </Link>
                </div>
                <form onSubmit={submit} method="POST">
                    <div className="space-y-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            className="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.name && <p className="text-red-500 text-sm">{errors.name}</p>}
                    </div>

                    <div className="space-y-2 mt-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            className="mt-2 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.email && <p className="text-red-500 text-sm">{errors.email}</p>}
                    </div>

                    <div className="space-y-2 mt-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Dob.
                        </label>
                        <input
                            type="date"
                            name="contact_no"
                            value={data.dob}
                            onChange={(e) => setData('dob', e.target.value)}
                            className="mt-2 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.dob && <p className="text-red-500 text-sm">{errors.dob}</p>}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="mt-2 cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {processing ? 'Submitting...' : 'Submit'}
                    </button>
                </form>
                {error && (
                    <div className='flex justify-center'>
                        <div className="mb-4 p-4 text-red-700 bg-red-100 border border-red-300 rounded mt-2 w-80 text-center">
                            {error}
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
