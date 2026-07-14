import { Head, Link, usePage } from '@inertiajs/react'
import Alert from "../Components/Alert.jsx";

export default function Layout({ children, title, isHome = false }) {
    const { auth } = usePage().props || {}

    const isAdmin = auth?.user?.role === 'admin';

    return (
        <>
            <Head title={isHome ? 'Bibliotek' : (title ? `${title} — Bibliotek` : 'Bibliotek')} />

            <nav className="bg-slate-950 text-slate-100 border-slate-900 shadow-lg relative z-50">
                <div className="container mx-auto px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">

                    <div className="flex items-center gap-8 w-full sm:w-auto">
                        <Link href="/" className="text-2xl sm:text-3xl font-bold tracking-tight text-white transition duration-200">
                            Bibliotek<span className="text-[#b91c1c]">.</span>
                        </Link>

                        <div className="hidden md:flex items-center gap-6 text-sm font-medium text-slate-400">
                            <Link href="/categories" className="hover:text-[#b91c1c] transition-colors duration-200">Categorias</Link>
                            <Link href="/authors" className="hover:text-[#b91c1c] transition-colors duration-200">Autores</Link>

                            {auth?.user && (
                                <>
                                    {isAdmin ? (
                                        <a
                                            href="/admin"
                                            className="text-amber-400 hover:text-amber-300 font-semibold transition-colors duration-200 flex items-center gap-1 border-l border-slate-800 pl-6"
                                        >
                                            <span className="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                            Painel Admin
                                        </a>
                                    ) : (
                                        <div className="flex items-center gap-6 border-l border-slate-800 pl-6">
                                            <a href="/reader" className="hover:text-white transition-colors duration-200">
                                                Minha Biblioteca
                                            </a>
                                            <a href="/reader/reading-list" className="hover:text-white transition-colors duration-200">
                                                Lista de Leitura
                                            </a>
                                        </div>
                                    )}
                                </>
                            )}
                        </div>
                    </div>

                    <div className="flex items-center gap-4 w-full sm:w-auto justify-center sm:justify-end">
                        {auth?.user ? (
                            <>
                                <span className="text-sm font-semibold text-slate-200 truncate max-w-[150px]">
                                    {auth.user.name}
                                </span>

                                <a href={isAdmin ? "/admin/profile" : "/reader/profile"} className="text-slate-400 hover:text-white transition-colors duration-200 p-1.5 rounded-lg hover:bg-slate-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-5 h-5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </a>

                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    title="Sair da Conta"
                                    className="text-slate-400 hover:text-rose-400 transition-colors duration-200 p-1.5 rounded-lg hover:bg-slate-800 flex items-center"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-5 h-5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                    </svg>
                                </Link>
                            </>
                        ) : (
                            <>
                                <Link href="/login" className="text-slate-300 hover:text-white transition-colors duration-200 px-3 py-1.5 text-sm font-medium">
                                    Entrar
                                </Link>
                                <Link href="/register" className="bg-[#b91c1c] hover:bg-[#991b1b] text-white text-xs font-semibold tracking-wider px-4 py-2 rounded-lg transition-colors duration-200">
                                    Criar conta
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </nav>

            <Alert />

            {isHome ? (
                <>{children}</>
            ) : (
                <main className="container mx-auto my-8 px-6 flex-1">
                    {children}
                </main>
            )}
        </>
    )
}
