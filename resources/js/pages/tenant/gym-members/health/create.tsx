import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gym Members',
        href: '/gym_members',
    },
];

export default function CreateGymMemberHealth({id, error}) {
    const {data, setData, errors, post, processing} = useForm({
        height: '',
        weight: '',
    })

    function submit(e) {
        e.preventDefault();
        post('/tenant/gym_members/store_health/'+id);
    }
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Gym" />
            <div className="container ms-auto p-4">
                <div className='flex justify-between items-center mb-4'>
                    <h1 className='text-2xl font-bold'>Add Gym member Health</h1>
                    <Link href="/tenant/gym_members" className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>
                        Back
                    </Link>
                </div>
                <form onSubmit={submit} method="POST">
                    <div className="space-y-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Height (In Inch)
                        </label>
                        <input
                            type="number"
                            name="height"
                            value={data.height}
                            onChange={(e) => setData('height', e.target.value)}
                            className="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.height && <p className="text-red-500 text-sm">{errors.height}</p>}
                    </div>

                    <div className="space-y-2 mt-2">
                        <label className="block text-sm font-medium text-gray-700">
                            Weight (In KG)
                        </label>
                        <input
                            type="number"
                            name="weight"
                            value={data.weight}
                            onChange={(e) => setData('weight', e.target.value)}
                            className="mt-2 block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none"
                        />
                        {errors.weight && <p className="text-red-500 text-sm">{errors.weight}</p>}
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
