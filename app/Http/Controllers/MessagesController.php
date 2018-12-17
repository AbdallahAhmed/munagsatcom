<?php

namespace App\Http\Controllers;

use App\Model\Channel;
use App\Model\Message;
use Illuminate\Http\Request;
use Validator;

class MessagesController extends Controller
{

    /**
     * POST /api/getChannels
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChannels(Request $request)
    {
        $data = ['data' => [], 'errors' => []];
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 6);
        $channels = Channel::where('sender_id', fauth()->id())
            ->orWhere('receiver_id', fauth()->id())
            ->orderBy('updated_at', 'DESC')
            ->take($limit)->offset($offset)->get();
        $data['data']['channels'] = $channels;
        return response()->json($data);
    }


    /**
     * POST api/pushMessage
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pushMessage(Request $request)
    {
        $data = ['data' => [], 'errors' => []];
        $validator = Validator::make($request->all(), [
            'channelId' => 'exists:channels,id',
            'message' => 'required',
            'userId' => 'exists:users,id',
        ]);
        $validator->sometimes('userId', 'required|exists:users,id', function () use ($request) {
            return !$request->filled('channelId');
        });
        if ($validator->fails()) {
            $data['errors'] = ($validator->errors()->all());
            return response()->json($data, 400);
        }
        // Channel id sent
        if ($request->filled('channelId')) {
            $channel = Channel::find($request->get('channelId'));
            return $this->pushMessageByChannel($request, $data, $channel);
        }
        // User id send
        $userId = $request->get('userId');
        $channel = Channel::user($userId)->first(); // Their exist old channels
        if (!$channel) { // new Channels
            $channel = Channel::create([
                'sender_id' => fauth()->id(),
                'receiver_id' => $request->get('userId')
            ]);
        }
        return $this->pushMessageByChannel($request, $data, $channel);
    }


    /**
     * POST /api/getChannelMessages
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChannelMessages(Request $request)
    {
        $data = ['data' => [], 'errors' => []];
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 6);
        $validator = Validator::make($request->all(), [
            'channelId' => 'exists:channels,id',
            'userId' => 'exists:users,id',
        ]);
        $validator->sometimes('userId', 'required|exists:users,id', function () use ($request) {
            return !$request->filled('channelId');
        });
        $validator->sometimes('channelId', 'required|exists:channels,id', function () use ($request) {
            return !$request->filled('userId');
        });

        if ($validator->fails()) {
            $data['errors'] = ($validator->errors()->all());
            return response()->json($data, 400);
        }
        // If send Channel ID
        if ($request->filled('channelId')) {
            $channel_id = $request->get('channelId');
            $messages = Message::where('channel_id', $channel_id)->orderBy('created_at', 'DESC')->offset($offset)->take($limit)->get();
            $data['data']['messages'] = $messages;
            return response()->json($data);
        }
        // send user ID
        $channel = Channel::user($request->get('userId'))->first();
        $messages = collect();
        if ($channel) {
            $messages = Message::where('channel_id', $channel->id)->orderBy('created_at', 'DESC')->offset($offset)->take($limit)->get();
        }
        $data['data']['messages'] = $messages;
        $data['data']['channel'] = $channel;
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param $data
     * @param $channel
     * @return \Illuminate\Http\JsonResponse
     */
    protected function pushMessageByChannel(Request $request, $data, $channel)
    {
        $channel->touch();
        Message::create(
            [
                'message' => $request->get('message'),
                'channel_id' => $channel->id,
                'sender_id' => fauth()->id(),
                'seen' => '1'
            ]
        );
        $data['data']['channel']=$channel;
        $data['data']['status']=true;
        return response()->json($data);
    }
}
