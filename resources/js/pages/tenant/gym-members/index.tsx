import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gym Members',
        href: '/tenant/gym_members',
    },
];

export default function GymMembers({ gym_members }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Gym" />
            <div className='container ms-auto p-4'>
                <div className='flex justify-between items-center mb-4'>
                    <h1 className='text-2xl font-bold'>Data</h1>
                    <Link href="/tenant/gym_members/create" className='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>
                        Add Gym Member
                    </Link>
                </div>
                <div className='overflow-x-auto'>
                    <table className='w-full table-auto shadow-lg bg-white dark:bg-gray-800 rounded-lg'>
                        <thead className='bg-gray-50 dark:bg-gray-700'>
                            <tr>
                                <th className='px-4 py-2'>#</th>
                                <th className='px-4 py-2'>Name</th>
                                <th className='px-4 py-2'>Email</th>
                                <th className='px-4 py-2'>Dob</th>
                                <th className='px-4 py-2'>Height</th>
                                <th className='px-4 py-2'>Weight</th>
                                <th className='px-4 py-2'>BMI</th>
                                <th className='px-4 py-2'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {gym_members.map((gym_member) => {
                                return (
                                    <tr key={gym_member.id} className='border-b border-natural-100 dark:border-natural-700'>
                                        <td className='px-4 py-2'>{gym_member.id}</td>
                                        <td className='px-4 py-2'>{gym_member.name}</td>
                                        <td className='px-4 py-2'>{gym_member.email}</td>
                                        <td className='px-4 py-2'>{new Date(gym_member.dob).toLocaleDateString('en-GB')}</td>
                                        <td className='px-4 py-2'>{gym_member.gym_member_health[0]?.height || ''}</td>
                                        <td className='px-4 py-2'>{gym_member.gym_member_health[0]?.weight || ''}</td>
                                        <td className='px-4 py-2'>{gym_member.gym_member_health[0]?.bmi || ''}</td>
                                        <td className='px-4 py-2 flex space-x-2'>
                                            <Link as="button" href={`/tenant/gym_members/${gym_member.id}/edit`}
                                                className='cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded'>
                                                Edit    
                                            </Link>
                                            <Link as="button" href={`/tenant/gym_members/add_health/${gym_member.id}`} 
                                                className='cursor-pointer bg-red-500 hover:bg-red-700 text-white font-bold px-4 rounded'>
                                                Health    
                                            </Link>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}

