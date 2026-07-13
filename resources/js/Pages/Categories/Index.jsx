import { Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';

export default function Index({ categories }) {
    return (
        <>
            <div className="mb-12 text-center sm:text-left">
                <h1 className="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter">
                    Explore por Gênero
                </h1>
                <p className="text-slate-500 mt-2 max-w-xl text-base">
                    Encontre o livro navegando pelos seus temas favoritos.
                </p>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {categories.map((category) => (
                    <Link
                        key={category.id}
                        href={`/categories/${category.id}/books`}
                        className="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-slate-200/60 transition-all duration-300 flex justify-between items-center"
                    >
                        <div className="space-y-1 min-w-0">
                            <h3 className="font-bold text-slate-900 group-hover:text-[#b91c1c] transition-colors duration-200 capitalize text-lg tracking-tight truncate">
                                {category.name}
                            </h3>

                            <span className="inline-flex items-center text-xs font-medium text-slate-400">
                                <span className="w-1.5 h-1.5 rounded-full bg-slate-300 mr-2 group-hover:bg-[#b91c1c] transition-colors duration-200"></span>
                                {category.books_count} {category.books_count === 1 ? 'livro disponível' : 'livros disponíveis'}
                            </span>
                        </div>

                        <span className="text-slate-300 group-hover:text-[#b91c1c] group-hover:translate-x-1 transform text-xl font-light transition-all duration-200 pl-4">
                            →
                        </span>
                    </Link>
                ))}
            </div>
        </>
    );
}

Index.layout = page => <Layout children={page} title="Categorias" />
