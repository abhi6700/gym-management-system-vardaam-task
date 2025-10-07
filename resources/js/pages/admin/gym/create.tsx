import AppLayout from '@/layouts/app-layout';
import password from '@/routes/password';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Add Gym',
        href: '/gym',
    },
];

export default function CreateGym() {
    const {data, setData, errors, post, reset, processing} = useForm({
        name: '',
        email: '',
        contact_no: '',
        address: '',
        password: '',
    })

    function submit(e) {
        e.preventDefault();
        post('/admin/gym');
    }
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Gym" />
            <div className="container ms-auto p-4">
                <div className='flex justify-between items-center mb-4'>
                    <h1 className='text-2xl font-bold'>Add Gym</h1>
                    <Link href="/admin/gym" className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>
                        Back
                    </Link>
                </div>
                <form onSubmit={submit} method="POST">
                    <div className="space-y-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Gym Name
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
                            Gym Email
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
                            Gym Contact No.
                        </label>
                        <input
                            type="text"
                            name="contact_no"
                            value={data.contact_no}
                            onChange={(e) => setData('contact_no', e.target.value)}
                            className="mt-2 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.contact_no && <p className="text-red-500 text-sm">{errors.contact_no}</p>}
                    </div>

                    <div className="space-y-2 mt-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Gym Address
                        </label>
                        <textarea
                            name="address"
                            value={data.address}
                            onChange={(e) => setData('address', e.target.value)}
                            className="mt-2 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.address && <p className="text-red-500 text-sm">{errors.address}</p>}
                    </div>
                    <div className="space-y-2 mt-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            className="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.password && <p className="text-red-500 text-sm">{errors.password}</p>}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="mt-2 cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {processing ? 'Submitting...' : 'Submit'}
                    </button>
                </form>
            </div>
        </AppLayout>
    );
}
