import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gym',
        href: '/admin/gym',
    },
];

export default function Gyms({gyms}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Gym" />
            <div className='container ms-auto p-4'>
                <div className='flex justify-between items-center mb-4'>
                    <h1 className='text-2xl font-bold'>Data</h1>
                    <Link href="/admin/gym/create" className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>
                        Add Gym
                    </Link>
                </div>
                <div className='overflow-x-auto'>
                    <table className='w-full table-auto shadow-lg bg-white dark:bg-gray-800 rounded-lg'>
                        <thead className='bg-gray-50 dark:bg-gray-700'>
                            <tr>
                                <th className='px-4 py-2'>#</th>
                                <th className='px-4 py-2'>Name</th>
                                <th className='px-4 py-2'>Email</th>
                                <th className='px-4 py-2'>Contect No.</th>
                                <th className='px-4 py-2'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {gyms.map((gym, index) => (
                                <tr key={gym.id} className='border-b border-natural-100
                                    dark:border-natural-700'>
                                    <td className='px-4 py'>{index + 1}</td>
                                    <td className='px-4 py'>{gym.name}</td>
                                    <td className='px-4 py'>{gym.email}</td>
                                    <td className='px-4 py'>{gym.contact_no}</td>
                                    <td className='px-4 py'>
                                        <Link as="button" href={`/admin/gym/${gym.id}/edit`} 
                                            className='cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded mr-2'>
                                            Edit    
                                        </Link>
                                        <Link href={`/admin/gym/${gym.id}`}
                                            as="button"
                                            onClick={(e) => {
                                                if (!confirm('Are you sure you want to delete this gym?')) {
                                                    e.preventDefault();
                                                }
                                            }}
                                            method='delete' className='cursor-pointer bg-red-500 hover:bg-red-700 text-white font-bold  px-4 rounded'>
                                            Delete    
                                        </Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
