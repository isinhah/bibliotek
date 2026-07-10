import { Link, Head, usePage } from '@inertiajs/react'

export default function Layout({ children, title, isHome = false}) {
    const { auth } = usePage().props || {}

    return (
        <>
            <Head title={title ? `${title} — Bibliotek` : 'Bibliotek'} />

            <nav className="bg-slate-950 text-slate-100 border-slate-900 shadow-lg relative z-50">
                <div className="container mx-auto px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">

                    <div className="flex items-center gap-8 w-full sm:w-auto">
                        <Link href="/" className="text-2xl sm:text-3xl font-bold tracking-tight text-white transition duration-200">
                            Bibliotek<span className="text-[#b91c1c]">.</span>
                        </Link>
                        <div className="hidden md:flex items-center gap-6 text-sm font-medium text-slate-400">
                            <Link href="/categories" className="hover:text-[#b91c1c] transition-colors duration-200">Categorias</Link>
                            <Link href="/authors" className="hover:text-[#b91c1c] transition-colors duration-200">Autores</Link>
                        </div>
                    </div>

                    <div className="flex items-center gap-2 text-sm font-medium w-full sm:w-auto justify-center sm:justify-end">
                        {auth?.user ? (
                            <>
                                {auth.user.is_admin ? (
                                    <a href="/admin" className="flex items-center gap-1.5 text-slate-300 hover:text-white bg-slate-900 hover:bg-slate-800 px-3 py-1.5 rounded-lg transition-colors duration-200">
                                        <span>Painel Admin</span>
                                    </a>
                                ) : (
                                    <a href="/reader" className="flex items-center gap-1.5 text-slate-300 hover:text-white bg-slate-900 hover:bg-slate-800 px-3 py-1.5 rounded-lg transition-colors duration-200">
                                        <span>Minha Biblioteca</span>
                                    </a>
                                )}

                                <div className="w-px h-4 bg-slate-700 mx-1"></div>

                                <a
                                    href={auth.user.is_admin ? '/admin/profile' : '/reader/profile'}
                                    title="Perfil"
                                    className="text-slate-400 hover:text-white transition-colors duration-200 p-1.5 rounded-lg hover:bg-slate-800"
                                >
                                    Perfil
                                </a>

                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    className="text-slate-400 hover:text-rose-400 transition-colors duration-200 p-1.5 rounded-lg hover:bg-slate-800"
                                >
                                    Sair
                                </Link>
                            </>
                        ) : (
                            <>
                                <Link href="/login" className="text-slate-300 hover:text-white transition-colors duration-200 px-3 py-1.5">
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
