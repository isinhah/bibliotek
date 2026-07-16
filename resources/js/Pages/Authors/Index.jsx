import { useForm, Link } from '@inertiajs/react';
import Layout from '../../Layouts/Layout';
import { Button } from "@/Components/ui/Button.jsx";

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
            <header className="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 pb-6 border-b-2 border-border-hard">
                <div>
                    <h1 className="text-sm sm:text-base font-minecraft font-black text-text-primary uppercase tracking-wider flex items-center gap-3 [text-shadow:2px_2px_0_rgba(0,0,0,0.8)]">
                        <span className="w-2.5 h-8 bg-oak border-2 border-border-hard rounded-none"></span>
                        Autores
                    </h1>
                    <p className="text-text-secondary mt-2 max-w-xl text-sm font-mono font-semibold">
                        Conheça os escritores e autores disponíveis no nosso acervo.
                    </p>
                </div>
            </header>

            <div className="mb-14 space-y-6">
                <div className="w-full">
                    <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-3 w-full max-w-xl">
                        <div className="relative flex-1">
                            <input
                                type="text"
                                value={data.search}
                                onChange={e => setData('search', e.target.value)}
                                placeholder="Pesquisar autor por nome..."
                                className="w-full font-mono text-xs font-semibold bg-panel-alt text-text-primary border-2 border-border-hard rounded-none h-10 pl-4 pr-10 outline-none focus:ring-2 focus:ring-primary focus:border-border-hard shadow-hard placeholder:text-text-secondary/50"
                            />
                            {data.search && (
                                <button
                                    type="button"
                                    onClick={handleClearSearch}
                                    className="absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary hover:text-danger font-mono font-bold text-xs"
                                >
                                    ✕
                                </button>
                            )}
                        </div>
                        <Button type="submit" variant="primary" className="h-10">
                            Buscar
                        </Button>
                    </form>
                </div>

                <div className="flex flex-wrap gap-2 p-3 bg-panel rounded-none border-2 border-border-hard shadow-hard">
                    {alphabet.map(letter => {
                        const isSelected = data.letter === letter;
                        return (
                            <Button
                                key={letter}
                                type="button"
                                onClick={() => handleLetterClick(letter)}
                                variant={isSelected ? "primary" : "outline"}
                                className={`w-9 h-9 p-0 flex items-center justify-center font-mono font-bold text-xs transition-all rounded-none ${
                                    isSelected ? 'scale-105 shadow-[2px_2px_0px_0px_#000000]' : ''
                                }`}
                            >
                                {letter}
                            </Button>
                        );
                    })}
                </div>
            </div>

            {authors.data.length === 0 ? (
                <div className="text-center py-24 bg-panel-alt border-2 border-border-hard rounded-none shadow-hard max-w-lg mx-auto">
                    <span className="text-4xl block mb-4">✍️</span>
                    <p className="text-text-primary font-mono font-bold text-sm">
                        Nenhum autor cadastrado com esses critérios.
                    </p>
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {authors.data.map(author => (
                        <Link
                            key={author.id}
                            href={`/authors/${author.id}/books`}
                            className="group relative flex flex-col justify-between h-32 p-5 bg-panel-alt text-text-primary border-2 border-border-hard shadow-hard hover:-translate-x-1 hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_rgba(225,29,72,0.15)] hover:border-primary transition-all duration-300 rounded-none overflow-hidden"
                        >
                            <div className="space-y-1.5 min-w-0 relative z-10">
                                <h3 className="font-mono font-black uppercase text-lg tracking-tight truncate capitalize group-hover:text-primary transition-colors duration-200">
                                    {author.name}
                                </h3>

                                <span className="inline-flex items-center text-xs font-mono font-bold text-text-secondary">
                                    <span className="w-1.5 h-1.5 bg-oak border border-border-hard mr-2 rounded-none group-hover:bg-primary group-hover:border-primary transition-colors duration-200"></span>
                                    {author.books_count} {author.books_count === 1 ? 'obra catalogada' : 'obras catalogadas'}
                                </span>
                            </div>

                            <div className="flex justify-end relative z-10">
                                <span className="text-xs font-mono font-bold text-text-secondary group-hover:text-primary transition-all duration-200 flex items-center gap-1">
                                    Ver obras
                                    <span className="inline-block transform group-hover:translate-x-1 transition-transform duration-200">
                                        →
                                    </span>
                                </span>
                            </div>
                        </Link>
                    ))}
                </div>
            )}

            {authors.links && authors.data.length > 0 && (
                <div className="mt-12 flex justify-between items-center bg-panel px-6 py-4 rounded-none border-2 border-border-hard shadow-hard">
                    {authors.prev_page_url ? (
                        <Link
                            href={authors.prev_page_url}
                            className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-2 border-border-hard font-mono text-xs font-bold uppercase select-none outline-none active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all bg-secondary text-secondary-foreground hover:bg-secondary/80 shadow-hard"
                        >
                            ◀ Anterior
                        </Link>
                    ) : (
                        <span className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-transparent bg-transparent text-text-primary font-mono text-xs font-bold uppercase select-none opacity-50 cursor-not-allowed">
                            ◀ Anterior
                        </span>
                    )}

                    <span className="font-mono text-xs font-bold text-text-secondary">
                        Pág. {authors.current_page} de {authors.last_page}
                    </span>

                    {authors.next_page_url ? (
                        <Link
                            href={authors.next_page_url}
                            className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-2 border-border-hard font-mono text-xs font-bold uppercase select-none outline-none active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all bg-secondary text-secondary-foreground hover:bg-secondary/80 shadow-hard"
                        >
                            Próximo ▶
                        </Link>
                    ) : (
                        <span className="group/button inline-flex h-10 px-5 gap-2 shrink-0 items-center justify-center rounded-none border-transparent bg-transparent text-text-primary font-mono text-xs font-bold uppercase select-none opacity-50 cursor-not-allowed">
                            Próximo ▶
                        </span>
                    )}
                </div>
            )}
        </>
    );
}

Index.layout = page => <Layout children={page} title="Autores" />
