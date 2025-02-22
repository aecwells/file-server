<?php

namespace App\Http\Controllers;

use App\Models\SmbHost;
use Illuminate\Http\Request;

class SmbHostController extends Controller
{
    public function index()
    {
        $smbHosts = SmbHost::all();
        return view('smb_hosts.index', compact('smbHosts'));
    }

    public function create()
    {
        return view('smb_hosts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required',
            'username' => 'required',
            'password' => 'required|string|min:8|confirmed|same:password_confirmation',
            'remote_path' => 'required',
            'port' => 'required|integer',
        ]);

        SmbHost::create([
            'name' => $request->name,
            'host' => $request->host,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'remote_path' => $request->remote_path,
            'port' => $request->port,
        ]);

        return redirect()->route('smb_hosts.index')->with('success', 'SMB Host created successfully.');
    }

    public function show(SmbHost $smbHost)
    {
        return view('smb_hosts.show', compact('smbHost'));
    }

    public function edit(SmbHost $smbHost)
    {
        return view('smb_hosts.edit', compact('smbHost'));
    }

    public function update(Request $request, SmbHost $smbHost)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required',
            'username' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
            'remote_path' => 'required',
            'port' => 'required|integer',
        ]);

        $smbHost->update([
            'name' => $request->name,
            'host' => $request->host,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $smbHost->password,
            'remote_path' => $request->remote_path,
            'port' => $request->port,
        ]);

        return redirect()->route('smb_hosts.index')->with('success', 'SMB Host updated successfully.');
    }

    public function destroy(SmbHost $smbHost)
    {
        $smbHost->delete();
        return redirect()->route('smb_hosts.index')->with('success', 'SMB Host deleted successfully.');
    }
}
