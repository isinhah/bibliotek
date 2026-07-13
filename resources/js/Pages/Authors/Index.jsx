import { useForm, Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';

export default function Index({ authors, searchTerm, selectedLetter, alphabet }) {
    const { data, setData, get } = useForm({
        search: searchTerm || '',
        letter: selectedLetter || ''
    });

    const handleSearch = (e) => {
        e.preventDefault();
        get('/authors', { preserveState: true });
    };

    const handleLetterClick = (letter) => {
        const nextLetter = data.letter === letter ? '' : letter;
        setData('letter', nextLetter);

        get(`/authors?search=${data.search}&letter=${nextLetter}`, { preserveState: true });
    };

    const handleClearSearch = () => {
        setData('search', '');
        get(`/authors?search=&letter=${data.letter}`, { preserveState: true });
    };

    return (
        <>
            <header className="mb-12 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                <div>
                    <h1 className="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter">
                        Escritores e Autores
                    </h1>
                    <p className="text-slate-500 mt-2 max-w-xl text-base">
                        Conheça os escritores e autores disponíveis no nosso acervo.
                    </p>
                </div>

                <span className="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/40">
                    Total: {authors.total} autores
                </span>
            </header>

            <div className="mb-14 space-y-6">
                <div className="max-w-xl">
                    <form onSubmit={handleSearch} className="relative group m-0">
                        <input
                            type="text"
                            value={data.search}
                            onChange={e => setData('search', e.target.value)}
                            placeholder="Pesquisar autor por nome..."
                            className="w-full pl-6 pr-12 py-3.5 bg-white border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#b91c1c] focus:border-transparent transition-all placeholder-slate-400 text-sm font-medium"
                        />

                        {searchTerm && (
                            <button
                                type="button"
                                onClick={handleClearSearch}
                                className="absolute right-10 top-3.5 text-slate-400 hover:text-slate-600 text-sm transition"
                            >
                                ✕
                            </button>
                        )}

                        <button type="submit" className="absolute right-4 top-3.5 text-slate-400 hover:text-[#b91c1c] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="w-5 h-5">
                                <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </form>

                    {searchTerm && (
                        <div className="text-xs text-slate-400 font-medium mt-2 pl-2">
                            Encontrado(s) {authors.total} autor(es) para "{searchTerm}"
                        </div>
                    )}
                </div>

                <div className="flex flex-wrap gap-1.5 p-2 bg-slate-100 rounded-2xl border border-slate-200/40">
                    {alphabet.map(letter => (
                        <button
                            key={letter}
                            type="button"
                            onClick={() => handleLetterClick(letter)}
                            className={`w-8 h-8 flex items-center justify-center text-xs font-bold rounded-xl transition-all ${
                                data.letter === letter
                                    ? 'bg-[#b91c1c] text-white shadow-md scale-105'
                                    : 'text-slate-600 hover:bg-white hover:text-[#b91c1c] shadow-xs'
                            }`}
                        >
                            {letter}
                        </button>
                    ))}
                </div>
            </div>

            {authors.data.length === 0 ? (
                <div className="bg-white p-16 rounded-2xl shadow-sm text-center border border-slate-100 text-slate-500 text-sm font-medium">
                    Nenhum autor cadastrado com esses critérios.
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    {authors.data.map(author => (
                        <Link
                            key={author.id}
                            href={`/authors/${author.id}/books`}
                            className="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-slate-200/60 transition-all duration-300 flex justify-between items-center"
                        >
                            <div className="space-y-1 min-w-0">
                                <h3 className="font-bold text-slate-900 group-hover:text-[#b91c1c] transition-colors duration-200 capitalize text-lg tracking-tight truncate">
                                    {author.name}
                                </h3>
                                <span className="inline-flex items-center text-xs font-medium text-slate-400">
                                    <span className="w-1.5 h-1.5 rounded-full bg-slate-300 mr-2 group-hover:bg-[#b91c1c] transition-colors duration-200"></span>
                                    {author.books_count} {author.books_count === 1 ? 'livro no acervo' : 'livros no acervo'}
                                </span>
                            </div>

                            <span className="text-slate-300 group-hover:text-[#b91c1c] group-hover:translate-x-1 transform text-xl font-light transition-all duration-200 pl-4">
                                →
                            </span>
                        </Link>
                    ))}
                </div>
            )}

            {authors.links && authors.data.length > 0 && (
                <div className="mt-12 flex justify-between items-center bg-white px-4 py-3 rounded-xl border border-slate-100 shadow-xs">
                    <Link
                        href={authors.prev_page_url || '#'}
                        disabled={!authors.prev_page_url}
                        className={`px-4 py-2 text-xs font-semibold rounded-lg border transition ${
                            authors.prev_page_url
                                ? 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                : 'bg-slate-50 border-slate-100 text-slate-300 cursor-not-allowed'
                        }`}
                    >
                        Anterior
                    </Link>
                    <Link
                        href={authors.next_page_url || '#'}
                        disabled={!authors.next_page_url}
                        className={`px-4 py-2 text-xs font-semibold rounded-lg border transition ${
                            authors.next_page_url
                                ? 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50'
                                : 'bg-slate-50 border-slate-100 text-slate-300 cursor-not-allowed'
                        }`}
                    >
                        Próximo
                    </Link>
                </div>
            )}
        </>
    );
}

Index.layout = page => <Layout children={page} title="Autores" />
