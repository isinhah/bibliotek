import { useForm, Link } from '@inertiajs/react'
import Layout from '../../Layouts/Layout.jsx'

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
    })

    function submit(e) {
        e.preventDefault()
        post('/login', {
            preserveScroll: true
        })
    }

    return (
        <div className="max-w-md mx-auto bg-white p-10 rounded-2xl shadow-sm border border-slate-100 mt-16">
            <h2 className="text-3xl font-black text-slate-950 mb-8 text-center tracking-tighter">
                Acesse sua conta
            </h2>

            <form onSubmit={submit}>
                <div className="mb-5">
                    <label className="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">
                        E-mail
                    </label>
                    <input
                        type="email"
                        name="email"
                        value={data.email}
                        onChange={e => setData('email', e.target.value)}
                        className={`w-full px-4 py-3 bg-white border rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#b91c1c] text-sm text-slate-800 transition-all ${
                            errors.email ? 'border-red-500' : 'border-slate-200'
                        }`}
                        required
                    />
                    {errors.email && (
                        <span className="text-red-500 text-xs mt-1.5 block font-medium">
                            {errors.email}
                        </span>
                    )}
                </div>

                <div className="mb-8">
                    <label className="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">
                        Senha
                    </label>
                    <input
                        type="password"
                        name="password"
                        value={data.password}
                        onChange={e => setData('password', e.target.value)}
                        className={`w-full px-4 py-3 bg-white border rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#b91c1c] text-sm text-slate-800 transition-all ${
                            errors.password ? 'border-red-500' : 'border-slate-200'
                        }`}
                        required
                    />

                    {errors.password && (
                        <span className="text-red-500 text-xs mt-1.5 block font-medium">
                            {errors.password}
                        </span>
                    )}
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className={`w-full bg-slate-950 hover:bg-[#b91c1c] text-white font-semibold py-3 rounded-2xl transition duration-200 shadow-sm mb-6 focus:outline-none ${
                        processing ? 'opacity-50 cursor-not-allowed' : ''
                    }`}
                >
                    {processing ? 'Entrando...' : 'Entrar'}
                </button>

                <p className="text-center text-sm text-slate-500">
                    Não tem uma conta?
                    <Link
                        href="/register"
                        className="text-[#b91c1c] font-semibold hover:underline underline-offset-4 ml-1"
                    >
                        Cadastre-se
                    </Link>
                </p>
            </form>
        </div>
    )
}

Login.layout = page => <Layout children={page} title="Entrar" />
